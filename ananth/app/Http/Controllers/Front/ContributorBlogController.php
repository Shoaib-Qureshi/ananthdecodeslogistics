<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ContributorPost;
use App\Models\Blogs;
use App\Models\User;
use App\Models\PageBanner;
use Illuminate\Support\Str;

class ContributorBlogController extends Controller
{
    // /expert-desk — guest contributor posts
    public function contributors()
    {
        $posts = ContributorPost::with(['author', 'category'])
            ->published()
            ->orderByDesc('is_featured')
            ->latest('published_at')
            ->paginate(10);

        $banner = PageBanner::forKey('expert_desk');

        return view('contributors.index', compact('posts', 'banner'));
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

        return view('contributors.show', compact('post', 'related', 'htmlContent', 'tableOfContents', 'readingTime'))->with('seo', [
            'title' => $post->meta_title ?: $post->title,
            'description' => $post->meta_description ?: Str::limit($plainText, 155),
            'keywords' => $post->meta_keywords,
            'canonical' => $post->canonical_url ?: route('contributors.show', $post->slug),
            'image' => $this->publicAssetUrl($post->og_image, $post->featured_image_url),
            'robots' => $this->robotsContent((bool) ($post->robots_index ?? true), (bool) ($post->robots_follow ?? true)),
            'schema' => $post->schema_json_ld,
        ]);
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

        $banner = PageBanner::forKey('blog');

        return view('blog.index', compact('posts', 'banner'));
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
            ->take(8)
            ->get();

        return view('blog.show', compact('post', 'related', 'htmlContent', 'tableOfContents', 'readingTime'))->with('seo', [
            'title' => $post->meta_title ?: $post->title,
            'description' => $post->meta_description ?: Str::limit($plainText, 155),
            'keywords' => $post->meta_keywords,
            'canonical' => $post->canonical_url ?: route('blog.show', $post->slug),
            'image' => $this->publicAssetUrl($post->og_image ?: ($post->thumbnail ? 'media/' . $post->thumbnail : null), asset('img/site-banner.jpg')),
            'robots' => $this->robotsContent((bool) ($post->robots_index ?? true), (bool) ($post->robots_follow ?? true)),
            'schema' => $post->schema_json_ld,
        ]);
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
