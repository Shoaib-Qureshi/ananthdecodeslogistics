<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ContributorPost;
use App\Mail\ContributorApproved;
use App\Mail\ContributorRejected;
use App\Mail\PostApproved;
use App\Mail\PostRejected;
use App\Models\BlogCategories;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminContributorController extends Controller
{
    // ── Registrations ────────────────────────────────────────────

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
        $user->update(['status' => 'approved']);

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
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        try {
            Mail::to($user->email)->send(new ContributorRejected($user));
        } catch (\Exception $e) {
            //
        }

        return redirect()->back()->with('success', "{$user->name} has been rejected.");
    }

    // ── Posts ─────────────────────────────────────────────────────

    public function posts(Request $request)
    {
        $status = $request->get('status', 'pending');
        $posts  = ContributorPost::with(['author', 'category'])
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
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|max:255',
            'body'             => 'required|string|min:100',
            'status'           => 'required|in:pending,published,rejected',
            'featured_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'rejection_reason' => 'nullable|string|max:1000',
        ]);

        $category = $this->contributorCategory();

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

        $post->update([
            'title'            => $request->title,
            'slug'             => ContributorPost::generateUniqueSlug($request->slug, $post->id),
            'body'             => $request->body,
            'category_id'      => $category->id,
            'featured_image'   => $imagePath,
            'status'           => $status,
            'published_at'     => $status === 'published' ? ($post->published_at ?? now()) : null,
            'rejection_reason' => $status === 'rejected' ? $request->rejection_reason : null,
        ]);

        return redirect()->route('admin.contributor.posts', ['status' => $status])->with('success', "Post \"{$post->title}\" updated.");
    }

    public function approvePost(Request $request, $id)
    {
        $post = ContributorPost::with('author')->findOrFail($id);
        $post->update([
            'status'       => 'published',
            'published_at' => now(),
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
            'status'           => 'rejected',
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
}
