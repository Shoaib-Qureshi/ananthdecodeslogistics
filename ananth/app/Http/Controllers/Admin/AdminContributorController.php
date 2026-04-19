<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesFaqs;
use App\Http\Controllers\Controller;
use App\Mail\ContributorApproved;
use App\Mail\ContributorRejected;
use App\Mail\PostApproved;
use App\Mail\PostRejected;
use App\Models\BlogCategories;
use App\Models\ContributorPlan;
use App\Models\ContributorPost;
use App\Models\User;
use App\Support\ContributorPlans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AdminContributorController extends Controller
{
    use HandlesFaqs;

    public function registrations(Request $request)
    {
        $status = $request->get('status', 'pending');
        $registrations = User::where('user_role', 'guest')
            ->where('status', $status)
            ->latest()
            ->paginate(10);

        return view('admin.contributor.registrations', compact('registrations', 'status'));
    }

    public function approveRegistration(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $planCode = ContributorPlans::normalize($user->contributor_plan, ContributorPlans::FREE);

        $user->update([
            'status' => 'approved',
            'contributor_plan' => $planCode,
            'payment_status' => $user->payment_status ?: (ContributorPlans::isComplimentary($planCode) ? 'complimentary' : 'paid'),
        ]);

        Password::sendResetLink(['email' => $user->email]);

        try {
            Mail::to($user->email)->send(new ContributorApproved($user));
        } catch (\Exception $e) {
            //
        }

        return redirect()->back()->with('success', "{$user->name} has been approved. A password setup email has been sent.");
    }

    public function rejectRegistration(Request $request, $id)
    {
        $request->validate(['rejection_reason' => 'required|string|max:1000']);

        $user = User::findOrFail($id);
        $user->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        try {
            Mail::to($user->email)->send(new ContributorRejected($user));
        } catch (\Exception $e) {
            //
        }

        return redirect()->back()->with('success', "{$user->name} has been rejected.");
    }

    public function plans()
    {
        return view('admin.contributor.plans', [
            'plans' => ContributorPlans::adminSelectablePlans(),
            'storageReady' => Schema::hasTable('contributor_plans'),
        ]);
    }

    public function updatePlans(Request $request)
    {
        if (!Schema::hasTable('contributor_plans')) {
            return redirect()->route('admin.contributor.plans')
                ->with('error', 'Contributor plan storage is not available yet. Run the latest migration and try again.');
        }

        $validated = $request->validate([
            'plans' => ['required', 'array'],
            'plans.*.code' => ['required', Rule::in(ContributorPlans::adminSelectableCodes())],
            'plans.*.name' => 'required|string|max:255',
            'plans.*.admin_name' => 'required|string|max:255',
            'plans.*.public' => 'nullable|boolean',
            'plans.*.price' => 'required|integer|min:0',
            'plans.*.currency' => 'required|string|max:10',
            'plans.*.price_label' => 'required|string|max:255',
            'plans.*.duration_months' => 'nullable|integer|min:0',
            'plans.*.duration_label' => 'nullable|string|max:255',
            'plans.*.max_posts' => 'nullable|integer|min:0',
            'plans.*.post_limit_label' => 'nullable|string|max:255',
            'plans.*.homepage_feature' => 'nullable|boolean',
            'plans.*.summary' => 'nullable|string|max:2000',
            'plans.*.highlights_text' => 'nullable|string|max:4000',
            'plans.*.checkout_name' => 'required|string|max:255',
            'plans.*.checkout_description' => 'nullable|string|max:2000',
            'plans.*.success_label' => 'required|string|max:255',
            'plans.*.success_note' => 'nullable|string|max:2000',
            'plans.*.renew_cta' => 'nullable|string|max:255',
        ]);

        foreach ($validated['plans'] as $planData) {
            ContributorPlan::updateOrCreate(
                ['code' => $planData['code']],
                [
                    'is_public' => (bool) ($planData['public'] ?? false),
                    'name' => trim($planData['name']),
                    'admin_name' => trim($planData['admin_name']),
                    'price' => (int) $planData['price'],
                    'currency' => strtoupper(trim($planData['currency'])),
                    'price_label' => trim($planData['price_label']),
                    'duration_months' => $planData['duration_months'],
                    'duration_label' => $planData['duration_label'],
                    'max_posts' => $planData['max_posts'],
                    'post_limit_label' => $planData['post_limit_label'],
                    'homepage_feature' => (bool) ($planData['homepage_feature'] ?? false),
                    'summary' => $planData['summary'],
                    'highlights' => $this->normalizePlanHighlights($planData['highlights_text'] ?? null),
                    'checkout_name' => trim($planData['checkout_name']),
                    'checkout_description' => $planData['checkout_description'],
                    'success_label' => trim($planData['success_label']),
                    'success_note' => $planData['success_note'],
                    'renew_cta' => $planData['renew_cta'],
                ]
            );
        }

        ContributorPlans::clearCache();

        return redirect()->route('admin.contributor.plans')
            ->with('success', 'Contributor plans updated successfully. New pricing and plan copy are now live.');
    }

    public function posts(Request $request)
    {
        $status = $request->get('status', 'pending');
        $posts = ContributorPost::with(['author', 'category'])
            ->where('status', $status)
            ->latest()
            ->paginate(10);

        return view('admin.contributor.posts', compact('posts', 'status'));
    }

    public function editPost($id)
    {
        $post = ContributorPost::with(['author', 'category'])->findOrFail($id);
        $category = $this->contributorCategory();

        return view('admin.contributor.edit', compact('post', 'category'));
    }

    public function updatePost(Request $request, $id)
    {
        $post = ContributorPost::with('author')->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'body' => 'required|string|min:100',
            'status' => 'required|in:pending,published,rejected',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'rejection_reason' => 'nullable|string|max:1000',
            'is_featured' => 'nullable|in:0,1',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:1000',
            'canonical_url' => 'nullable|string|max:255',
            'og_image' => 'nullable|string|max:255',
            'robots_index' => 'nullable|in:0,1',
            'robots_follow' => 'nullable|in:0,1',
            'schema_json_ld' => 'nullable|string',
            'has_faqs' => 'nullable|boolean',
            'faq_items' => 'nullable|array|max:20',
            'faq_items.*.question' => 'nullable|string|max:255',
            'faq_items.*.answer' => 'nullable|string|max:5000',
        ]);

        $category = $this->contributorCategory();
        $faqPayload = $this->resolveFaqPayload($request);

        $imagePath = $post->featured_image;
        if ($request->hasFile('featured_image')) {
            if ($imagePath) {
                Storage::delete('public/posts/' . $imagePath);
            }

            $file = $request->file('featured_image');
            $filename = Str::slug($request->slug) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/posts', $filename);
            $imagePath = $filename;
        }

        $status = $request->status;
        $isFeatured = $request->boolean('is_featured');

        $post->update([
            'title' => $request->title,
            'slug' => ContributorPost::generateUniqueSlug($request->slug, $post->id),
            'body' => $request->body,
            'category_id' => $category->id,
            'featured_image' => $imagePath,
            'is_featured' => $isFeatured,
            'feature_source_plan' => $isFeatured ? $post->author->contributorPlanCode() : null,
            'has_faqs' => $faqPayload['has_faqs'],
            'faqs' => $faqPayload['faqs'],
            'status' => $status,
            'published_at' => $status === 'published' ? ($post->published_at ?? now()) : null,
            'rejection_reason' => $status === 'rejected' ? $request->rejection_reason : null,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'canonical_url' => $request->canonical_url,
            'og_image' => $request->og_image,
            'robots_index' => $request->input('robots_index', 1),
            'robots_follow' => $request->input('robots_follow', 1),
            'schema_json_ld' => $request->schema_json_ld,
        ]);

        return redirect()->route('admin.contributor.posts', ['status' => $status])->with('success', "Post \"{$post->title}\" updated.");
    }

    public function approvePost(Request $request, $id)
    {
        $post = ContributorPost::with('author')->findOrFail($id);
        $isFeatured = $post->is_featured || $post->author->hasFeaturedContributorPlan();

        $post->update([
            'status' => 'published',
            'published_at' => now(),
            'is_featured' => $isFeatured,
            'feature_source_plan' => $isFeatured ? $post->author->contributorPlanCode() : null,
        ]);

        try {
            Mail::to($post->author->email)->send(new PostApproved($post));
        } catch (\Exception $e) {
            //
        }

        return redirect()->back()->with('success', "Post \"{$post->title}\" published.");
    }

    public function rejectPost(Request $request, $id)
    {
        $request->validate(['rejection_reason' => 'required|string|max:1000']);

        $post = ContributorPost::with('author')->findOrFail($id);
        $post->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        try {
            Mail::to($post->author->email)->send(new PostRejected($post));
        } catch (\Exception $e) {
            //
        }

        return redirect()->back()->with('success', "Post \"{$post->title}\" rejected.");
    }

    public function deletePost($id)
    {
        $post = ContributorPost::findOrFail($id);
        $title = $post->title;
        $post->delete();

        return redirect()->back()->with('success', "Post \"{$title}\" deleted.");
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

    private function normalizePlanHighlights(?string $value): array
    {
        $lines = preg_split("/\r\n|\n|\r/", (string) $value) ?: [];

        return array_values(array_filter(
            array_map(static fn ($line) => trim($line), $lines),
            static fn (string $line): bool => $line !== ''
        ));
    }
}
