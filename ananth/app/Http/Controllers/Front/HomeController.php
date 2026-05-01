<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Blogs;
use App\Models\BlogCategories;
use App\Models\ContributorPost;
use App\Models\Contact;
use App\Models\TeamMember;
use App\Models\Milestone;
use App\Models\HomePageSetting;
use App\Models\AboutPageSetting;
use App\Models\Founder;
use App\Models\FounderCredential;
use App\Models\ServiceCard;
use App\Models\ExpertDeskPillar;
use App\Mail\ContactSubmissionAdminNotification;

class HomeController extends Controller
{
    private string $featuredSlug = 'from-the-desk-the-vision-behind-this-platform-and-distinguished-opportunities-for-you';

    public function homePage()
    {
        $settings    = HomePageSetting::first();
        $credentials = FounderCredential::orderBy('sort_order')->get();
        $services    = ServiceCard::where('visible', true)->orderBy('sort_order')->get();
        $pillars     = ExpertDeskPillar::orderBy('sort_order')->get();
        $featured    = Blogs::editorialByAnanth()
                            ->where('status', 1)
                            ->orderBy('created_at', 'desc')
                            ->limit(3)
                            ->get();

        $contributorPosts = ContributorPost::with(['author', 'category'])
                            ->published()
                            ->orderByDesc('is_featured')
                            ->latest('published_at')
                            ->limit(3)
                            ->get();

        return view('home', compact('settings', 'credentials', 'services', 'pillars', 'featured', 'contributorPosts'))->with('seo', [
            'title' => $settings?->meta_title ?: ($settings?->hero_heading ?? 'Ananth Decodes Logistics'),
            'description' => $settings?->meta_description ?: ($settings?->hero_subheading ?? 'Logistics insights, strategy, and thought-leadership by Dr. Ananthakrishnan Janardhanan.'),
            'canonical' => $settings?->canonical_url ?: url('/'),
            'image' => $this->publicAssetUrl($settings?->og_image ?: $settings?->hero_image, asset('img/site/About-us-banner.jpg')),
            'robots' => $this->robotsContent((bool) ($settings?->robots_index ?? true), (bool) ($settings?->robots_follow ?? true)),
            'schema' => $settings?->schema_json_ld,
        ]);
    }

    public function privacyPolicy()
    {
        return view('front.privacyPolicy');
    }

    public function termsConditions()
    {
        return view('front.termsConditions');
    } 

    public function contactUs()
    {
        return view('front.contactUs');
    }
    
    public function disclaimer()
    {
        return view('front.disclaimer');
    }

    public function aboutUs()
    {
        $settings = AboutPageSetting::first();
        $founders = Founder::where('visible', true)->orderBy('sort_order')->get();
        $services = ServiceCard::where('visible', true)->orderBy('sort_order')->get();

        return view('about', compact('settings', 'founders', 'services'))->with('seo', [
            'title' => $settings?->meta_title ?: (($settings?->hero_heading ?? 'About') . ' - Ananth Decodes Logistics'),
            'description' => $settings?->meta_description ?: ($settings?->hero_subheading ?? 'Meet the team behind Ananth Decodes Logistics Private Limited.'),
            'canonical' => $settings?->canonical_url ?: url('/about'),
            'image' => $this->publicAssetUrl($settings?->og_image ?: $settings?->hero_image, asset('img/site/About-us-banner.jpg')),
            'robots' => $this->robotsContent((bool) ($settings?->robots_index ?? true), (bool) ($settings?->robots_follow ?? true)),
            'schema' => $settings?->schema_json_ld,
        ]);
    }

    public function saveContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'message' => 'required|string|max:2000'
        ]);

        $contact = new Contact();
        $contact->name = $validated['name'];
        $contact->email = $validated['email'];
        $contact->phone = $validated['phone'] ?? null;
        $contact->organization = null;
        $contact->job_title = null;
        $contact->subject = null;
        $contact->service_interest = null;
        $contact->engagement_preference = null;
        $contact->message = $validated['message'];
        $contact->save();

        try {
            $adminEmail = config('mail.admin_email', 'admin@ananthdecodeslogistics.com');
            Mail::to($adminEmail)->send(new ContactSubmissionAdminNotification($contact));
        } catch (\Throwable $exception) {
            Log::error('Failed to send contact form admin notification.', [
                'contact_id' => $contact->id,
                'error' => $exception->getMessage(),
            ]);
        }

        return redirect()->back()->with('message', "Thanks for your message! We'll get back to you shortly.");
    }
    
    public function writeForUs()
    {
        return view('front.writeForUs');
    }

    private function publicAssetUrl(?string $path, string $fallback): string
    {
        if (!$path) {
            return $fallback;
        }

        return Str::startsWith($path, ['http://', 'https://'])
            ? $path
            : (Str::startsWith($path, ['img/', 'media/']) ? asset($path) : asset('storage/' . $path));
    }

    private function robotsContent(bool $index, bool $follow): string
    {
        return ($index ? 'index' : 'noindex') . ',' . ($follow ? 'follow' : 'nofollow');
    }
}
