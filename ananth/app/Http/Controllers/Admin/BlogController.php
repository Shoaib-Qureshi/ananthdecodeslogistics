<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\HandlesFaqs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Image;

use App\Models\User;
use App\Models\Blogs;
use App\Models\BlogCategories;
use App\Models\BookReview;

class BlogController extends Controller
{
    use HandlesFaqs;

    public function createBlog()
    {
        $users = User::all();
        $category = $this->getDefaultCategories();
        return view('admin.createBlog', [
            'category' => $category,
            'users' => $users
        ]);
    }

    public function saveBlog(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:blog_category,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:0,1',
            'visibility' => 'required|in:0,1,public,private',
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

        $faqPayload = $this->resolveFaqPayload($request);

        $post = new Blogs();
        $post->user_id = $request->user_id ?? Auth::id();
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->slug = Str::slug($request->input('title'));
        $post->content = $request->content;
        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->meta_keywords = $request->meta_keywords;
        $post->canonical_url = $request->canonical_url;
        $post->og_image = $request->og_image;
        $post->robots_index = $request->input('robots_index', 1);
        $post->robots_follow = $request->input('robots_follow', 1);
        $post->schema_json_ld = $request->schema_json_ld;
        $post->has_faqs = $faqPayload['has_faqs'];
        $post->faqs = $faqPayload['faqs'];
        $post->status = $request->status;
        // Convert string values to integers: public=1 (visible), private=0 (hidden)
        $post->visibility = ($request->visibility === 'public' || $request->visibility == 1) ? 1 : 0;

        if( $request->hasFile('thumbnail') ) {
            $image = $request->file('thumbnail');
            $filename = Str::slug($request->input('title'))."-".time().'.webp';
            $resizedImage = Image::make($image);
            if($resizedImage->height() > $resizedImage->width()){
                $width = 700;
                $height = null;
              }
              else{
                $width = 700;
                $height = 700;
              }
              $resizedImage->resize($width, $height, function ($constraint) {
                  $constraint->aspectRatio();
              })->save(public_path('media/' . $filename));
            $post->thumbnail = $filename;
        }
	    $post->save();
        return redirect('admin/live-blogs')->with('message', 'Article Published As Draft!');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo(Str::slug($originName), PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.webp';

            $image = $request->file('upload');
            $resizedImage = Image::make($image);

            if($resizedImage->height() > $resizedImage->width()){
                $width = 700;
                $height = null;
              }
              else{
                $width = 700;
                $height = 700;
              }
              $resizedImage->resize($width, $height, function ($constraint) {
                  $constraint->aspectRatio();
              })->save(public_path('media/' . $fileName));
            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }

    public function liveBlogs(Request $request)
    {
        if(isset($_GET['query'])){            
            $search_blog = $_GET['query'];
            $searchblog = Blogs::orderBy('created_at','desc')->where('title', 'LIKE', '%'.$search_blog.'%')->paginate(50);       
            $searchblog->appends($request->all());
            return view('admin/liveBlogs', ['searchblog'=>$searchblog]);
        }else{
            $searchblog = Blogs::orderBy('created_at','desc')->paginate(50);
            return view('admin/liveBlogs', ['searchblog'=>$searchblog]);
        }
    }

    public function draftBlogs(Request $request)
    {
        if(isset($_GET['query'])){
            
            $search_text = $_GET['query'];
            $search_post = Blogs::orderBy('created_at','desc')->where([['title', 'LIKE', '%'.$search_text.'%'], ['status', '0']])->paginate(50);       
            $search_post->appends($request->all());
            return view('admin/draftBlogs', ['search_post'=>$search_post]);
        }else{
            $search_post = Blogs::orderBy('created_at','desc')->where('status', '0')->paginate(50);
            return view('admin/draftBlogs', ['search_post'=>$search_post]);
        }   
    }

    public function editBlog($id)
    {
        $editBlog = Blogs::find($id);
        $category = $this->getDefaultCategories();
        $users = User::all();
        return view('admin/editBlog', [
            'editBlog' => $editBlog,
            'category' => $category,
            'users' => $users
        ]);
    
    }

    public function updateBlog(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:blog_category,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
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

        $faqPayload = $this->resolveFaqPayload($request);

        $update_blog = Blogs::findOrFail($id);
        $update_blog->user_id = $request->user_id;
        $update_blog->content = $request->content;
        $update_blog->title = $request->title;
        $update_blog->meta_title = $request->meta_title;
        $update_blog->meta_description = $request->meta_description;
        $update_blog->meta_keywords = $request->meta_keywords;
        $update_blog->canonical_url = $request->canonical_url;
        $update_blog->og_image = $request->og_image;
        $update_blog->robots_index = $request->input('robots_index', 1);
        $update_blog->robots_follow = $request->input('robots_follow', 1);
        $update_blog->schema_json_ld = $request->schema_json_ld;
        $update_blog->has_faqs = $faqPayload['has_faqs'];
        $update_blog->faqs = $faqPayload['faqs'];
        $update_blog->status = $request->status ?? $update_blog->status;
        // Convert string values to integers: public=1 (visible), private=0 (hidden)
        if ($request->has('visibility')) {
            $update_blog->visibility = ($request->visibility === 'public' || $request->visibility == 1) ? 1 : 0;
        }
        $update_blog->category_id = $request->category_id;
        $update_blog->slug = $request->slug;

        if( $request->hasFile('thumbnail') ) {
            $image = $request->file('thumbnail');
            $filename = Str::slug($request->input('title'))."-".time().'.webp';
            $resizedImage = Image::make($image);
            if($resizedImage->height() > $resizedImage->width()){
                $width = 700;
                $height = null;
              }
              else{
                $width = 700;
                $height = 700;
              }
              $resizedImage->resize($width, $height, function ($constraint) {
                  $constraint->aspectRatio();
              })->save(public_path('media/' . $filename));
            $update_blog->thumbnail = $filename;
        }
        
        $update_blog->save();
        return redirect('admin/live-blogs')->with('message', 'Article Successfully Updated!');
    }

    public function deleteBlog($id)
    {
        $post_data = Blogs::find($id);
        $post_data->delete();
        return redirect('admin/live-blogs')->with('message', 'Article Successfully Deleted!');
    }
    
    public function bookReviewList(Request $request)
    {
        if(isset($_GET['query'])){            
            $search_blog = $_GET['query'];
            $searchblog = BookReview::orderBy('created_at','desc')->where('name', 'LIKE', '%'.$search_blog.'%')->paginate(50);       
            $searchblog->appends($request->all());
            return view('admin.bookReviewList', ['searchblog'=>$searchblog]);
        }else{
            $searchblog = BookReview::orderBy('created_at','desc')->paginate(50);
            return view('admin.bookReviewList', ['searchblog'=>$searchblog]);
        }
    }

    public function addBookReview()
    {
        return view('admin.addBookReview');
    }

    public function saveBookReview(Request $request)
    {
        $addBook = new BookReview();
        $addBook->name = $request->name;
        $addBook->slug = Str::slug($request->input('name'));
        $addBook->author = $request->author;
        $addBook->genre = $request->genre;
        $addBook->published = $request->published;
        $addBook->short_description = $request->short_description;        
        $addBook->detail_review = $request->detail_review;
        $addBook->buy_link = $request->buy_link;

        if( $request->hasFile('cover') ) {
            $image = $request->file('cover');
            $filename = Str::slug($request->input('name'))."-".time().'.webp';
            $resizedImage = Image::make($image);
            if($resizedImage->height() > $resizedImage->width()){
                $width = 600;
                $height = null;
              }
              else{
                $width = 600;
                $height = 600;
              }
              $resizedImage->resize($width, $height, function ($constraint) {
                  $constraint->aspectRatio();
              })->save(public_path('img/thumbnail/' . $filename));
            $addBook->cover = $filename;
        }
	    $addBook->save();
        return redirect('admin/book-reviews')->with('message', 'Book Review Published As Draft!');
    }

    public function editBookReview($id)
    {
        $editBook = BookReview::find($id);
        return view('admin/editBookReview', [
            'editBook' => $editBook,
        ]);
    
    }

    public function updatedBookReview(Request $request, $id)
    {
        $updateBook = BookReview::find($request->id);;
        $updateBook->name = $request->name;
        $updateBook->slug = $request->slug;
        $updateBook->author = $request->author;
        $updateBook->genre = $request->genre;
        $updateBook->published = $request->published;
        $updateBook->short_description = $request->short_description;        
        $updateBook->detail_review = $request->detail_review;
        $updateBook->buy_link = $request->buy_link;
        $updateBook->status = $request->status;

        if( $request->hasFile('cover') ) {
            $image = $request->file('cover');
            $filename = Str::slug($request->input('name'))."-".time().'.webp';
            $resizedImage = Image::make($image);
            if($resizedImage->height() > $resizedImage->width()){
                $width = 600;
                $height = null;
              }
              else{
                $width = 600;
                $height = 600;
              }
              $resizedImage->resize($width, $height, function ($constraint) {
                  $constraint->aspectRatio();
              })->save(public_path('img/thumbnail/' . $filename));
            $updateBook->cover = $filename;
        }
	    $updateBook->save();
        return redirect('admin/book-reviews')->with('message', 'Book Review Successfully Updated!');
    }    

    /**
     * Ensure only the default editorial categories are offered.
     */
    private function getDefaultCategories()
    {
        $slugColumn = Schema::hasColumn('blog_category', 'category_slug')
            ? 'category_slug'
            : (Schema::hasColumn('blog_category', 'slug') ? 'slug' : null);
        $nameColumn = Schema::hasColumn('blog_category', 'category_name')
            ? 'category_name'
            : (Schema::hasColumn('blog_category', 'name') ? 'name' : null);

        // If table is missing required columns, avoid querying invalid fields
        if (is_null($slugColumn) || is_null($nameColumn)) {
            return collect([]);
        }

        $defaults = [
            [
                'category_name' => 'Transport & Logistics',
                'category_slug' => 'transport-logistics',
                'name' => 'Transport & Logistics',
                'slug' => 'transport-logistics',
            ],
        ];

        foreach ($defaults as $category) {
            BlogCategories::updateOrCreate(
                [$slugColumn => $category['category_slug']],
                [
                    $nameColumn => $category['category_name'],
                    $slugColumn => $category['category_slug'],
                ]
            );
        }

        $slugs = array_column($defaults, 'category_slug'); // same values for slug fallback

        return BlogCategories::whereIn($slugColumn, $slugs)
            ->get();
    }

}
