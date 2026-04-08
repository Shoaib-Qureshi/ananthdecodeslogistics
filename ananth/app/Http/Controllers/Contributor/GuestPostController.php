<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Concerns\HandlesFaqs;
use App\Http\Controllers\Concerns\HandlesUserProfileUpdates;
use App\Http\Controllers\Controller;
use App\Mail\NewPostAdminNotification;
use App\Models\BlogCategories;
use App\Models\ContributorPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class GuestPostController extends Controller
{
    use HandlesFaqs;
    use HandlesUserProfileUpdates;

    public function index()
    {
        $user = Auth::user();

        $posts = ContributorPost::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => ContributorPost::where('user_id', Auth::id())->count(),
            'pending' => ContributorPost::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'approved' => ContributorPost::where('user_id', Auth::id())->whereIn('status', ['approved', 'published'])->count(),
            'rejected' => ContributorPost::where('user_id', Auth::id())->where('status', 'rejected')->count(),
            'published' => ContributorPost::where('user_id', Auth::id())->where('status', 'published')->count(),
        ];

        return view('dashboard.index', [
            'posts' => $posts,
            'stats' => $stats,
            'canSubmitPosts' => $user->canSubmitContributorPosts($stats['total']),
            'submissionRestrictionMessage' => $user->contributorSubmissionRestrictionMessage($stats['total']),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->submissionGuard()) {
            return $redirect;
        }

        $category = $this->contributorCategory();

        return view('dashboard.posts.create', compact('category'));
    }

    public function editProfile()
    {
        return view('dashboard.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $this->updateProfileFromRequest($request, Auth::user());

        return redirect()->route('dashboard.profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->submissionGuard()) {
            return $redirect;
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'has_faqs' => 'nullable|boolean',
            'faq_items' => 'nullable|array|max:20',
            'faq_items.*.question' => 'nullable|string|max:255',
            'faq_items.*.answer' => 'nullable|string|max:5000',
        ]);

        $category = $this->contributorCategory();
        $faqPayload = $this->resolveFaqPayload($request);

        $slug = ContributorPost::generateUniqueSlug($request->title);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/posts', $filename);
            $imagePath = $filename;
        }

        $user = Auth::user();

        $post = ContributorPost::create([
            'user_id' => Auth::id(),
            'category_id' => $category->id,
            'title' => $request->title,
            'slug' => $slug,
            'body' => $request->body,
            'featured_image' => $imagePath,
            'is_featured' => $user && $user->hasFeaturedContributorPlan(),
            'feature_source_plan' => $user && $user->hasFeaturedContributorPlan() ? $user->contributorPlanCode() : null,
            'has_faqs' => $faqPayload['has_faqs'],
            'faqs' => $faqPayload['faqs'],
            'status' => 'pending',
        ]);

        try {
            $adminEmail = config('mail.admin_email', 'admin@ananthdecodeslogistics.com');
            Mail::to($adminEmail)->send(new NewPostAdminNotification($post));
        } catch (\Exception $e) {
            //
        }

        return redirect('/dashboard/posts')->with('success', 'Your post has been submitted for review.');
    }

    public function edit($id)
    {
        if ($redirect = $this->submissionGuard()) {
            return $redirect;
        }

        $post = ContributorPost::where('user_id', Auth::id())->findOrFail($id);
        $category = $this->contributorCategory();

        return view('dashboard.posts.edit', compact('post', 'category'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->submissionGuard()) {
            return $redirect;
        }

        $post = ContributorPost::where('user_id', Auth::id())->findOrFail($id);
        $user = Auth::user();

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'has_faqs' => 'nullable|boolean',
            'faq_items' => 'nullable|array|max:20',
            'faq_items.*.question' => 'nullable|string|max:255',
            'faq_items.*.answer' => 'nullable|string|max:5000',
        ]);

        $category = $this->contributorCategory();
        $faqPayload = $this->resolveFaqPayload($request);

        $slug = ContributorPost::generateUniqueSlug($request->title, $post->id);

        $imagePath = $post->featured_image;
        if ($request->hasFile('featured_image')) {
            if ($imagePath) {
                Storage::delete('public/posts/' . $imagePath);
            }
            $file = $request->file('featured_image');
            $filename = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/posts', $filename);
            $imagePath = $filename;
        }

        $post->update([
            'title' => $request->title,
            'slug' => $slug,
            'body' => $request->body,
            'category_id' => $category->id,
            'featured_image' => $imagePath,
            'is_featured' => $user && $user->hasFeaturedContributorPlan(),
            'feature_source_plan' => $user && $user->hasFeaturedContributorPlan() ? $user->contributorPlanCode() : null,
            'has_faqs' => $faqPayload['has_faqs'],
            'faqs' => $faqPayload['faqs'],
            'status' => 'pending',
            'published_at' => null,
            'rejection_reason' => null,
        ]);

        try {
            $adminEmail = config('mail.admin_email', 'admin@ananthdecodeslogistics.com');
            Mail::to($adminEmail)->send(new NewPostAdminNotification($post));
        } catch (\Exception $e) {
            //
        }

        return redirect('/dashboard/posts')->with('success', 'Your changes were saved and sent back for admin approval.');
    }

    private function submissionGuard()
    {
        $user = Auth::user();

        if (!$user || $user->canSubmitContributorPosts()) {
            return null;
        }

        return redirect()
            ->route('dashboard')
            ->with('error', $user->contributorSubmissionRestrictionMessage());
    }

    private function contributorCategory(): BlogCategories
    {
        $slugColumn = Schema::hasColumn('blog_category', 'category_slug')
            ? 'category_slug'
            : (Schema::hasColumn('blog_category', 'slug') ? 'slug' : null);
        $nameColumn = Schema::hasColumn('blog_category', 'category_name')
            ? 'category_name'
            : (Schema::hasColumn('blog_category', 'name') ? 'name' : null);

        abort_if(is_null($slugColumn) || is_null($nameColumn), 500, 'Contributor category columns are missing.');

        return BlogCategories::updateOrCreate(
            [$slugColumn => 'transport-logistics'],
            [
                $nameColumn => 'Transport & Logistics',
                $slugColumn => 'transport-logistics',
            ]
        );
    }
}
