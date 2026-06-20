<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EventRegistrationConfirmed;
use App\Mail\EventRegistrationNotInterested;
use App\Mail\EventSponsorPaymentReceived;
use App\Models\Event;
use App\Models\EventAgendaItem;
use App\Models\EventFaq;
use App\Models\EventRegistration;
use App\Models\EventSponsorPackage;
use App\Models\EventSponsorPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /* ── Multi-event management ─────────────────────────────── */

    public function index()
    {
        $events = Event::orderBy('event_date', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $event = new Event(['active_sponsor_currency' => 'INR', 'tax_label' => 'GST', 'tax_percentage' => 18]);
        $formAction = route('admin.events.store');
        return view('admin.events.edit', compact('event', 'formAction'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event.name'                   => 'required|string|max:160',
            'event.chapter'                => 'nullable|string|max:180',
            'event.tagline'                => 'nullable|string|max:240',
            'event.event_date'             => 'nullable|date',
            'event.location'               => 'nullable|string|max:180',
            'event.format'                 => 'nullable|string|max:120',
            'event.is_active'              => 'nullable|boolean',
            'event.active_sponsor_currency'=> 'required|in:INR,USD',
            'event.tax_label'              => 'nullable|string|max:40',
            'event.tax_percentage'         => 'nullable|numeric|min:0|max:50',
        ]);

        $payload = $validated['event'];
        $this->normalizeEventRequiredFields($payload);
        $payload['slug'] = \Illuminate\Support\Str::slug($payload['name'] . '-' . ($payload['event_date'] ?? now()->year));
        if (Event::where('slug', $payload['slug'])->exists()) {
            $payload['slug'] .= '-' . uniqid();
        }
        $payload['is_active'] = false;

        $event = Event::create($payload);
        return redirect()->route('admin.events.event.edit', $event)->with('success', 'Event created. Fill in the full details below.');
    }

    public function editEvent(Event $event)
    {
        $event->load(['agendaItems', 'faqs']);
        $formAction = route('admin.events.event.update', $event);
        return view('admin.events.edit', compact('event', 'formAction'));
    }

    public function updateEvent(Request $request, Event $event)
    {
        $request->validate(['hero_image_file' => 'nullable|image|max:4096']);
        $validated = $request->validate($this->eventValidationRules());

        $payload = $validated['event'];
        $this->normalizeEventRequiredFields($payload, $event);
        $payload['hero_image'] = $this->resolveHeroImage($request, $event->hero_image);
        $payload['theme_points']           = $this->lines($request->input('theme_points_text'));
        $payload['comparison_rows']        = $this->comparisonRows($request->input('comparison_rows_text'));
        $payload['attendee_profiles']      = $this->lines($request->input('attendee_profiles_text'));
        $payload['exhibitor_benefits']     = $this->lines($request->input('exhibitor_benefits_text'));
        $payload['exhibitor_package_notes']= $this->lines($request->input('exhibitor_package_notes_text'));
        $payload['sponsor_benefits']       = $this->lines($request->input('sponsor_benefits_text'));
        $payload['sponsor_inclusions']     = $this->lines($request->input('sponsor_inclusions_text'));
        $payload['interest_options']       = $this->interestOptions($request->input('interest_options_text'));
        $payload['registration_steps']     = $this->registrationSteps($request->input('registration_steps_text'));

        $event->update($payload);
        $this->syncAgenda($event, $request->input('agenda', []));
        $this->syncFaqs($event, $request->input('faqs', []));

        return back()->with('success', 'Event updated.');
    }

    public function activate(Event $event)
    {
        Event::query()->update(['is_active' => false]);
        $event->update(['is_active' => true]);
        return back()->with('success', '"' . $event->name . '" is now the active event.');
    }

    public function destroy(Event $event)
    {
        if ($event->is_active) {
            return back()->withErrors(['error' => 'Cannot delete the active event. Activate another event first.']);
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }

    /* ── Current-event edit (legacy, kept for existing route) ── */

    public function edit()
    {
        $event = Event::current()->load(['agendaItems', 'faqs']);
        $formAction = route('admin.events.update');
        return view('admin.events.edit', compact('event', 'formAction'));
    }

    public function update(Request $request)
    {
        $event = Event::current();
        $request->validate(['hero_image_file' => 'nullable|image|max:4096']);
        $validated = $request->validate($this->eventValidationRules());

        $payload = $validated['event'];
        $this->normalizeEventRequiredFields($payload, $event);
        $payload['hero_image'] = $this->resolveHeroImage($request, $event->hero_image);
        $payload['theme_points']            = $this->lines($request->input('theme_points_text'));
        $payload['comparison_rows']         = $this->comparisonRows($request->input('comparison_rows_text'));
        $payload['attendee_profiles']       = $this->lines($request->input('attendee_profiles_text'));
        $payload['exhibitor_benefits']      = $this->lines($request->input('exhibitor_benefits_text'));
        $payload['exhibitor_package_notes'] = $this->lines($request->input('exhibitor_package_notes_text'));
        $payload['sponsor_benefits']        = $this->lines($request->input('sponsor_benefits_text'));
        $payload['sponsor_inclusions']      = $this->lines($request->input('sponsor_inclusions_text'));
        $payload['interest_options']        = $this->interestOptions($request->input('interest_options_text'));
        $payload['registration_steps']      = $this->registrationSteps($request->input('registration_steps_text'));
        $payload['is_active']               = true;

        $event->update($payload);
        $this->syncAgenda($event, $request->input('agenda', []));
        $this->syncFaqs($event, $request->input('faqs', []));

        return back()->with('success', 'LogiSphere event content updated.');
    }

    public function packages()
    {
        $event = Event::current();
        $packages = $event->sponsorPackages()->get();

        return view('admin.events.packages', compact('event', 'packages'));
    }

    public function updatePackages(Request $request)
    {
        $event = Event::current();

        $request->validate([
            'packages' => 'nullable|array',
            'packages.*.id' => 'nullable|integer',
            'packages.*.name' => 'nullable|string|max:120',
            'packages.*.slot_count' => 'nullable|integer|min:0',
            'packages.*.price_inr' => 'nullable|numeric|min:0',
            'packages.*.price_usd' => 'nullable|numeric|min:0',
            'packages.*.included_passes' => 'nullable|integer|min:0',
            'packages.*.description' => 'nullable|string|max:2500',
            'packages.*.benefits_text' => 'nullable|string',
            'packages.*.sort_order' => 'nullable|integer',
            'packages.*._delete' => 'nullable|boolean',
        ]);

        foreach ($request->input('packages', []) as $row) {
            if (!empty($row['_delete']) && !empty($row['id'])) {
                EventSponsorPackage::where('event_id', $event->id)->whereKey($row['id'])->delete();
                continue;
            }

            $name = trim((string) ($row['name'] ?? ''));
            if ($name === '') {
                continue;
            }

            $package = !empty($row['id'])
                ? EventSponsorPackage::where('event_id', $event->id)->whereKey($row['id'])->first()
                : new EventSponsorPackage(['event_id' => $event->id]);

            if (!$package) {
                continue;
            }

            $package->fill([
                'name' => $name,
                'slug' => Event::slugifyPackage($name),
                'slot_count' => (int) ($row['slot_count'] ?? 0),
                'price_inr' => (float) ($row['price_inr'] ?? 0),
                'price_usd' => (float) ($row['price_usd'] ?? 0),
                'included_passes' => (int) ($row['included_passes'] ?? 0),
                'description' => $row['description'] ?? null,
                'benefits' => $this->lines($row['benefits_text'] ?? ''),
                'sort_order' => (int) ($row['sort_order'] ?? 0),
                'visible' => !empty($row['visible']),
            ])->save();
        }

        return back()->with('success', 'Sponsor packages updated.');
    }

    public function registrations(Request $request)
    {
        $registrations = EventRegistration::with('event')
            ->when($request->filled('type'), fn ($query) => $query->where('inquiry_type', $request->type))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(40)
            ->withQueryString();

        return view('admin.events.registrations', compact('registrations'));
    }

    public function updateRegistrationStatus(Request $request, EventRegistration $registration)
    {
        $request->validate(['status' => 'required|in:new,contacted,confirmed,not_interested,closed']);
        $previousStatus = $registration->status;
        $newStatus = $request->status === 'closed' ? 'not_interested' : $request->status;
        $registration->update(['status' => $newStatus]);

        if ($previousStatus !== 'confirmed' && $newStatus === 'confirmed') {
            try {
                Mail::to($registration->email)->send(new EventRegistrationConfirmed($registration->fresh('event')));
            } catch (\Throwable $exception) {
                Log::warning('Unable to send event registration confirmation email.', [
                    'registration_id' => $registration->id,
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        if (!in_array($previousStatus, ['not_interested', 'closed'], true) && $newStatus === 'not_interested') {
            try {
                Mail::to($registration->email)->send(new EventRegistrationNotInterested($registration->fresh('event')));
            } catch (\Throwable $exception) {
                Log::warning('Unable to send event registration not interested email.', [
                    'registration_id' => $registration->id,
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        return back()->with('success', 'Registration status updated.');
    }

    public function payments()
    {
        $payments = EventSponsorPayment::with(['event', 'package'])->latest()->paginate(40);

        return view('admin.events.payments', compact('payments'));
    }

    public function markPaymentPaid(Request $request, EventSponsorPayment $payment)
    {
        $request->validate([
            'transfer_reference' => 'nullable|string|max:120',
        ]);

        if ($payment->status === 'paid') {
            return back()->with('success', 'This sponsor payment is already marked as paid.');
        }

        $payment->update([
            'status' => 'paid',
            'transfer_reference' => trim((string) $request->input('transfer_reference')) ?: null,
            'paid_at' => now(),
        ]);

        try {
            Mail::to($payment->email)->send(new EventSponsorPaymentReceived($payment->fresh(['event', 'package'])));
        } catch (\Throwable $exception) {
            Log::warning('Unable to send sponsor payment confirmation email.', [
                'payment_id' => $payment->id,
                'error' => $exception->getMessage(),
            ]);
        }

        return back()->with('success', 'Sponsor payment marked as paid and the invoice email has been sent.');
    }

    private function syncAgenda(Event $event, array $rows): void
    {
        foreach ($rows as $row) {
            if (!empty($row['_delete']) && !empty($row['id'])) {
                EventAgendaItem::where('event_id', $event->id)->whereKey($row['id'])->delete();
                continue;
            }

            $title = trim((string) ($row['title'] ?? ''));
            if ($title === '') {
                continue;
            }

            $item = !empty($row['id'])
                ? EventAgendaItem::where('event_id', $event->id)->whereKey($row['id'])->first()
                : new EventAgendaItem(['event_id' => $event->id]);

            if (!$item) {
                continue;
            }

            $item->fill([
                'start_time' => $row['start_time'] ?? null,
                'end_time' => $row['end_time'] ?? null,
                'duration' => $row['duration'] ?? null,
                'session_type' => $row['session_type'] ?? null,
                'title' => $title,
                'description' => $row['description'] ?? null,
                'sort_order' => (int) ($row['sort_order'] ?? 0),
                'visible' => !empty($row['visible']),
            ])->save();
        }
    }

    private function syncFaqs(Event $event, array $rows): void
    {
        foreach ($rows as $row) {
            if (!empty($row['_delete']) && !empty($row['id'])) {
                EventFaq::where('event_id', $event->id)->whereKey($row['id'])->delete();
                continue;
            }

            $question = trim((string) ($row['question'] ?? ''));
            $answer = trim((string) ($row['answer'] ?? ''));
            if ($question === '' || $answer === '') {
                continue;
            }

            $faq = !empty($row['id'])
                ? EventFaq::where('event_id', $event->id)->whereKey($row['id'])->first()
                : new EventFaq(['event_id' => $event->id]);

            if (!$faq) {
                continue;
            }

            $faq->fill([
                'question' => $question,
                'answer' => $answer,
                'sort_order' => (int) ($row['sort_order'] ?? 0),
                'visible' => !empty($row['visible']),
            ])->save();
        }
    }

    private function normalizeEventRequiredFields(array &$payload, ?Event $event = null): void
    {
        $payload['tax_label'] = trim((string) ($payload['tax_label'] ?? '')) !== ''
            ? $payload['tax_label']
            : ($event && trim((string) $event->tax_label) !== '' ? $event->tax_label : 'GST');

        $payload['tax_percentage'] = $payload['tax_percentage'] ?? ($event?->tax_percentage ?? 18);
        if ($payload['tax_percentage'] === '') {
            $payload['tax_percentage'] = $event?->tax_percentage ?? 18;
        }

        $payload['active_sponsor_currency'] = strtoupper($payload['active_sponsor_currency'] ?? '') === 'USD' ? 'USD' : 'INR';
    }

    private function eventValidationRules(): array
    {
        return [
            'event.name'                    => 'required|string|max:160',
            'event.chapter'                 => 'nullable|string|max:180',
            'event.tagline'                 => 'nullable|string|max:240',
            'event.event_date'              => 'nullable|date',
            'event.event_time'              => 'nullable|string|max:120',
            'event.location'                => 'nullable|string|max:180',
            'event.venue_name'              => 'nullable|string|max:255',
            'event.venue_address'           => 'nullable|string|max:1000',
            'event.venue_map_embed'         => 'nullable|string|max:2000',
            'event.format'                  => 'nullable|string|max:120',
            'event.hero_image'              => ['nullable', 'string', 'max:2000', 'not_regex:/<[^>]+>/'],
            'event.welcome_note'            => 'nullable|string|max:4000',
            'event.about'                   => 'nullable|string|max:8000',
            'event.why_now'                 => 'nullable|string|max:5000',
            'event.why_who_eyebrow'         => 'nullable|string|max:120',
            'event.why_who_heading'         => 'nullable|string|max:180',
            'event.why_who_subheading'      => 'nullable|string|max:500',
            'event.theme_title'             => 'nullable|string|max:180',
            'event.exhibitor_intro'         => 'nullable|string|max:5000',
            'event.exhibitor_profile'       => 'nullable|string|max:5000',
            'event.sponsor_intro'           => 'nullable|string|max:5000',
            'event.sponsorship_eyebrow'     => 'nullable|string|max:120',
            'event.sponsorship_heading'     => 'nullable|string|max:180',
            'event.sponsorship_subheading'  => 'nullable|string|max:500',
            'event.registration_eyebrow'     => 'nullable|string|max:120',
            'event.registration_heading'     => 'nullable|string|max:180',
            'event.registration_subheading'  => 'nullable|string|max:500',
            'event.registration_panel_eyebrow' => 'nullable|string|max:120',
            'event.registration_panel_heading' => 'nullable|string|max:180',
            'event.registration_form_heading' => 'nullable|string|max:180',
            'event.registration_form_subheading' => 'nullable|string|max:500',
            'event.contact_email'           => 'nullable|email|max:180',
            'event.contact_note'            => 'nullable|string|max:3000',
            'event.closing_note'            => 'nullable|string|max:4000',
            'event.active_sponsor_currency' => 'required|in:INR,USD',
            'event.tax_label'               => 'nullable|string|max:40',
            'event.tax_percentage'          => 'nullable|numeric|min:0|max:50',
            'event.meta_title'              => 'nullable|string|max:180',
            'event.meta_description'        => 'nullable|string|max:260',
            'event.canonical_url'           => 'nullable|string|max:255',
            'theme_points_text'             => 'nullable|string',
            'comparison_rows_text'          => 'nullable|string',
            'attendee_profiles_text'        => 'nullable|string',
            'exhibitor_benefits_text'       => 'nullable|string',
            'exhibitor_package_notes_text'  => 'nullable|string',
            'sponsor_benefits_text'         => 'nullable|string',
            'sponsor_inclusions_text'       => 'nullable|string',
            'interest_options_text'         => 'nullable|string|max:2000',
            'registration_steps_text'       => 'nullable|string|max:3000',
            'agenda'                        => 'nullable|array',
            'agenda.*.id'                   => 'nullable|integer',
            'agenda.*.start_time'           => 'nullable|string|max:40',
            'agenda.*.end_time'             => 'nullable|string|max:40',
            'agenda.*.duration'             => 'nullable|string|max:80',
            'agenda.*.session_type'         => 'nullable|string|max:120',
            'agenda.*.title'                => 'nullable|string|max:255',
            'agenda.*.description'          => 'nullable|string|max:2500',
            'agenda.*.sort_order'           => 'nullable|integer',
            'agenda.*._delete'              => 'nullable|boolean',
            'faqs'                          => 'nullable|array',
            'faqs.*.id'                     => 'nullable|integer',
            'faqs.*.question'               => 'nullable|string|max:255',
            'faqs.*.answer'                 => 'nullable|string|max:4000',
            'faqs.*.sort_order'             => 'nullable|integer',
            'faqs.*._delete'                => 'nullable|boolean',
        ];
    }

    private function resolveHeroImage(Request $request, ?string $existingUrl): ?string
    {
        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $path = $file->store('events/hero', 'public');
            return Storage::disk('public')->url($path);
        }
        return $request->input('event.hero_image') ?: $existingUrl;
    }

    private function lines(?string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $text))));
    }

    private function comparisonRows(?string $text): array
    {
        return array_values(array_filter(array_map(function ($line) {
            $parts = array_map('trim', explode('|', $line, 2));
            if (count($parts) < 2 || $parts[0] === '' || $parts[1] === '') {
                return null;
            }

            return ['traditional' => $parts[0], 'logisphere' => $parts[1]];
        }, preg_split('/\r\n|\r|\n/', (string) $text))));
    }

    private function interestOptions(?string $text): array
    {
        $options = [];

        foreach (preg_split('/\r\n|\r|\n/', (string) $text) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = array_map('trim', explode('|', $line, 2));
            if (count($parts) === 2) {
                [$value, $label] = $parts;
            } else {
                $label = $parts[0];
                $value = Str::slug($label, '_');
            }

            $value = Str::slug($value, '_');
            if ($label === '' || $value === '') {
                continue;
            }

            $options[$value] = ['value' => $value, 'label' => $label];
        }

        return array_values($options ?: Event::defaultInterestOptions());
    }

    private function registrationSteps(?string $text): array
    {
        $steps = [];

        foreach (preg_split('/\r\n|\r|\n/', (string) $text) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = array_map('trim', explode('|', $line, 2));
            $steps[] = [
                'title' => $parts[0] ?? '',
                'text' => $parts[1] ?? '',
            ];
        }

        return $steps ?: Event::defaultRegistrationSteps();
    }
}
