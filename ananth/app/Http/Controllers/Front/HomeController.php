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
use App\Models\HomePage;
use App\Models\AboutPage;
use App\Models\Milestone;
use App\Mail\ContactSubmissionAdminNotification;

class HomeController extends Controller
{
    private string $featuredSlug = 'from-the-desk-the-vision-behind-this-platform-and-distinguished-opportunities-for-you';

    public function homePage()
    {
        $featured = Blogs::editorialByAnanth()
            ->where([['status', 1], ['slug', $this->featuredSlug]])
            ->first();

        $latestLimit = $featured ? 2 : 3;

        $latest = Blogs::editorialByAnanth()
            ->where('status', 1)
            ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->orderBy('created_at', 'desc')
            ->limit($latestLimit)
            ->get();

        // Fallback: if featured missing, pick the newest and re-run latest list to avoid duplicates
        if (!$featured) {
            $featured = Blogs::editorialByAnanth()
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->first();
            $latest = Blogs::editorialByAnanth()
                ->where('status', 1)
                ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
                ->orderBy('created_at', 'desc')
                ->limit($latestLimit)
                ->get();
        }
        $homeContent = HomePage::all()->keyBy('section_key');
        $featuredContributorPosts = ContributorPost::with(['author', 'category'])
            ->published()
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(3)
            ->get();
        $pageMeta = $homeContent->get('page_meta');

        return view('front.homePage', [
            'latest' => $latest,
            'featured' => $featured,
            'homeContent' => $homeContent,
            'featuredContributorPosts' => $featuredContributorPosts,
            'seo' => [
                'title' => $pageMeta->meta_title ?? 'Ananth Decodes Logistics',
                'description' => $pageMeta->meta_description ?? 'Ananthakrishnan J is a seasoned executive and strategic leader with over 25 years of distinguished experience in transport, logistics, and integrated facility management.',
                'keywords' => $pageMeta->meta_keywords ?? null,
                'canonical' => $pageMeta->canonical_url ?? url('/'),
                'image' => $this->publicAssetUrl($pageMeta->og_image ?? null, asset('img/site-banner.jpg')),
                'robots' => $this->robotsContent($pageMeta->robots_index ?? true, $pageMeta->robots_follow ?? true),
                'schema' => $pageMeta->schema_json_ld ?? null,
            ],
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
        $members = TeamMember::orderBy('position', 'asc')->get();
        $aboutContent = AboutPage::all()->keyBy('section_key');
        $milestones = Milestone::where('status', 1)->orderBy('position', 'asc')->get();
        $pageMeta = $aboutContent->get('page_meta');

        return view('front.aboutUs', [
            'members' => $members,
            'aboutContent' => $aboutContent,
            'milestones' => $milestones,
            'seo' => [
                'title' => $pageMeta->meta_title ?? 'About Us — Ananth Decodes Logistics',
                'description' => $pageMeta->meta_description ?? 'Learn more about Ananth Decodes Logistics, our founder, and our strategic vision in logistics and transport.',
                'keywords' => $pageMeta->meta_keywords ?? null,
                'canonical' => $pageMeta->canonical_url ?? url('about-us'),
                'image' => $this->publicAssetUrl($pageMeta->og_image ?? null, asset('img/site-banner.jpg')),
                'robots' => $this->robotsContent($pageMeta->robots_index ?? true, $pageMeta->robots_follow ?? true),
                'schema' => $pageMeta->schema_json_ld ?? null,
            ],
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
            : asset($path);
    }

    private function robotsContent(bool $index, bool $follow): string
    {
        return ($index ? 'index' : 'noindex') . ',' . ($follow ? 'follow' : 'nofollow');
    }
}
