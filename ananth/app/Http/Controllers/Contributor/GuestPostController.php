<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use App\Models\ContributorPost;
use App\Models\BlogCategories;
use App\Mail\NewPostAdminNotification;
use Illuminate\Support\Facades\Mail;

class GuestPostController extends Controller
{
    public function index()
    {
        $posts = ContributorPost::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $stats = [
            'total'     => ContributorPost::where('user_id', Auth::id())->count(),
            'pending'   => ContributorPost::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'approved'  => ContributorPost::where('user_id', Auth::id())->whereIn('status', ['approved', 'published'])->count(),
            'rejected'  => ContributorPost::where('user_id', Auth::id())->where('status', 'rejected')->count(),
            'published' => ContributorPost::where('user_id', Auth::id())->where('status', 'published')->count(),
        ];

        return view('dashboard.index', compact('posts', 'stats'));
    }

    public function create()
    {
        $category = $this->contributorCategory();
        return view('dashboard.posts.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'body'            => 'required|string|min:100',
            'featured_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $category = $this->contributorCategory();

        $slug = ContributorPost::generateUniqueSlug($request->title);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $file     = $request->file('featured_image');
            $filename = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/posts', $filename);
            $imagePath = $filename;
        }

        $post = ContributorPost::create([
            'user_id'        => Auth::id(),
            'category_id'    => $category->id,
            'title'          => $request->title,
            'slug'           => $slug,
            'body'           => $request->body,
            'featured_image' => $imagePath,
            'status'         => 'pending',
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
        $post = ContributorPost::where('user_id', Auth::id())->findOrFail($id);
        $category = $this->contributorCategory();
        return view('dashboard.posts.edit', compact('post', 'category'));
    }

    public function update(Request $request, $id)
    {
        $post = ContributorPost::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title'          => 'required|string|max:255',
            'body'           => 'required|string|min:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $category = $this->contributorCategory();

        $slug = ContributorPost::generateUniqueSlug($request->title, $post->id);

        $imagePath = $post->featured_image;
        if ($request->hasFile('featured_image')) {
            if ($imagePath) {
                Storage::delete('public/posts/' . $imagePath);
            }
            $file      = $request->file('featured_image');
            $filename  = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/posts', $filename);
            $imagePath = $filename;
        }

        $post->update([
            'title'          => $request->title,
            'slug'           => $slug,
            'body'           => $request->body,
            'category_id'    => $category->id,
            'featured_image' => $imagePath,
            'status'         => 'pending',
            'published_at'   => null,
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
