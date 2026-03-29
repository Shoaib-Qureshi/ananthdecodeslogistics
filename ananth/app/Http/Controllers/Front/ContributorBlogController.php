<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ContributorPost;
use App\Models\Blogs;
use App\Models\User;
use Illuminate\Support\Str;

class ContributorBlogController extends Controller
{
    // /contributors — guest contributor posts
    public function contributors()
    {
        $posts = ContributorPost::with(['author', 'category'])
            ->published()
            ->latest('published_at')
            ->paginate(10);

        return view('contributors.index', compact('posts'));
    }

    public function showContributor($slug)
    {
        $post = ContributorPost::with(['author', 'category'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $plainText = strip_tags($post->body);
        $wordCount = str_word_count($plainText);
        $readingTime = (int) ceil($wordCount / 175);

        $htmlContent = $post->body;
        preg_match_all('/<h([1-3])>(.*?)<\/h\1>/', $htmlContent, $headingTags);
        $tableOfContents = [];

        foreach ($headingTags[0] as $i => $tag) {
            $level = $headingTags[1][$i];
            $text = strip_tags($headingTags[2][$i]);
            $id = Str::slug($text);
            $updatedTag = str_replace('<h' . $level . '>', '<h' . $level . ' id="' . $id . '">', $tag);

            $tableOfContents[] = [
                'level' => $level,
                'text' => $text,
                'id' => $id,
            ];

            $htmlContent = str_replace($tag, $updatedTag, $htmlContent);
        }

        $related = ContributorPost::with(['author', 'category'])
            ->published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('contributors.show', compact('post', 'related', 'htmlContent', 'tableOfContents', 'readingTime'));
    }

    // /blog — Ananthakrishnan's admin posts only (delegates to existing logic)
    public function blog()
    {
        $posts = Blogs::with('user')
            ->editorialByAnanth()
            ->where('status', 1)
            ->where('visibility', 1)
            ->latest()
            ->paginate(10);

        return view('blog.index', compact('posts'));
    }

    public function showBlog($slug)
    {
        $post = Blogs::with('user')
            ->editorialByAnanth()
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $plainText = strip_tags($post->content);
        $wordCount = str_word_count($plainText);
        $readingTime = (int) ceil($wordCount / 175);

        $htmlContent = $post->content;
        preg_match_all('/<h([1-3])>(.*?)<\/h\1>/', $htmlContent, $headingTags);
        $tableOfContents = [];

        foreach ($headingTags[0] as $i => $tag) {
            $level = $headingTags[1][$i];
            $text = strip_tags($headingTags[2][$i]);
            $id = Str::slug($text);
            $updatedTag = str_replace('<h' . $level . '>', '<h' . $level . ' id="' . $id . '">', $tag);

            $tableOfContents[] = [
                'level' => $level,
                'text' => $text,
                'id' => $id,
            ];

            $htmlContent = str_replace($tag, $updatedTag, $htmlContent);
        }

        $related = Blogs::editorialByAnanth()
            ->where('status', 1)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'related', 'htmlContent', 'tableOfContents', 'readingTime'));
    }
}
