<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\User;
use App\Models\Blogs;
use App\Models\BlogCategories;
use App\Models\AboutPage;
use Illuminate\Support\Str;
use App\Models\BookReview;

class ArticleController extends Controller
{
    public function articlePage($slug)
    {
        try {
            $article = Blogs::leftJoin('users', 'users.id', 'blogs.user_id')
                ->leftJoin('blog_category', 'blog_category.id', 'blogs.category_id')
                ->select(
                    'blogs.*',
                    'users.name',
                    'users.username',
                    'users.profile_pic',
                    'blog_category.category_name',
                    'blog_category.category_slug'
                )
                ->where([['blogs.slug', $slug], ['blogs.status', 1], ['blogs.visibility', 1]])
                ->first();
        } catch (QueryException $e) {
            // Schema mismatch or other query error – fall back to 404 instead of surfacing an exception
            return response()->view('errors.404', [], 404);
        }

        if(is_null($article)){
            return response()->view('errors.404', [], 404);
        }

        $plainText = strip_tags($article->content);
        $wordCount = str_word_count($plainText);
        $wordsPerMinute = 175;
        $readingTime = (int) ceil($wordCount / $wordsPerMinute);

        $htmlContent = $article->content;
        preg_match_all('/<h([1-3])>(.*?)<\/h\1>/', $htmlContent, $headingTags);
        $tableOfContents = [];
        foreach ($headingTags[0] as $i => $tag) {
            $level = $headingTags[1][$i];
            $text = strip_tags($headingTags[2][$i]);
            $id = Str::slug($text);
            $tag = str_replace('<h'.$level.'>', '<h'.$level.' id="'.$id.'">', $tag);
            $tableOfContents[] = [
                'level' => $level,
                'text' => $text,
                'id' => $id,                
            ];
            $htmlContent = str_replace($headingTags[0][$i], $tag, $htmlContent);
        }
        
        $related = Blogs::where([['status', 1], ['visibility', 1]])->orderBy('created_at', 'desc')->limit(9)->get();
        $author = User::where('id', $article->user_id)->first();
        $founderProfile = AboutPage::where('section_key', 'founder_profile')->first();
        return view('blogs.articlePage', [
            'article' => $article,
            'related' => $related,
            'readingTime' => $readingTime,
            'htmlContent' => $htmlContent,
            'tableOfContents' => $tableOfContents,
            'author' => $author,
            'founderProfile' => $founderProfile
        ]);
    }

    public function allPost()
    {
        $featuredSlug = 'from-the-desk-the-vision-behind-this-platform-and-distinguished-opportunities-for-you';
        $featured = Blogs::where([['status', 1], ['visibility', 1], ['slug', $featuredSlug]])->first();

        $allPost = Blogs::where([['status', 1], ['visibility', 1]])
            ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('blogs.allPost', [
            'allPost' => $allPost,
            'featured' => $featured
        ]);
    }

    public function categoryPage($slug)
    {
        $category = BlogCategories::where('category_slug', $slug)->first();
        if(is_null($category)){
            return view('errors.404');
        }
        $featuredSlug = 'from-the-desk-the-vision-behind-this-platform-and-distinguished-opportunities-for-you';
        $featured = Blogs::where([
                ['category_id', $category->id],
                ['status', 1],
                ['visibility', 1],
                ['slug', $featuredSlug]
            ])->first();

        $blogs = Blogs::where([['category_id', $category->id], ['status', 1], ['visibility', 1]])
            ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('blogs.categoryPage', [
            'category' => $category,
            'blogs' => $blogs,
            'featured' => $featured

        ]);
    }

    public function authorPage($slug)
    {
        $author = User::where('username', $slug)->first();
        if(is_null($author)){
            return view('errors.404');
        }
        $blogs = Blogs::leftJoin('users', 'users.id', 'blogs.user_id')->select('blogs.*', 'users.name')->where([['blogs.user_id', $author->id], ['blogs.status', 1], ['blogs.visibility', 1]])->orderBy('blogs.created_at', 'desc')->paginate(6);
        
        return view('blogs.authorPage', [
            'author' => $author,
            'blogs' => $blogs,
            // Safety for legacy blade caches that referenced $article
            'article' => null,
            
        ]);
    }
    
    public function bookReviews()
    {
        $listBook = BookReview::where('status', 1)->orderBy('created_at', 'desc')->get();
        return view('reviews.bookReviews', [
            'listBook' => $listBook
        ]);
    }

    public function reviewPage($slug)
    {
        $bookDetail = BookReview::where([['slug', $slug],['status', 1]])->first();
        if(is_null($bookDetail)){
            return view('errors.404');
        }
        return view('reviews.reviewPage', [
            'bookDetail' => $bookDetail
        ]);
    }
}
