<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Image;

use App\Models\User;
use App\Models\BoardInsights;
use App\Models\PageBanner;

class BoardInsightsController extends Controller
{
    public function createInsight()
    {
        return view('admin.createInsight');
    }

    public function saveInsight(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:1000',
            'canonical_url' => 'nullable|string|max:255',
            'og_image' => 'nullable|string|max:255',
            'robots_index' => 'nullable|in:0,1',
            'robots_follow' => 'nullable|in:0,1',
            'schema_json_ld' => 'nullable|string',
        ]);

        $addInsight = new BoardInsights();
        $addInsight->title = $request->title;
        $addInsight->slug = Str::slug($request->input('title'));
        $addInsight->content = $request->content;
        $addInsight->meta_title = $request->meta_title;
        $addInsight->meta_description = $request->meta_description;
        $addInsight->meta_keywords = $request->meta_keywords;
        $addInsight->canonical_url = $request->canonical_url;
        $addInsight->og_image = $request->og_image;
        $addInsight->robots_index = $request->input('robots_index', 1);
        $addInsight->robots_follow = $request->input('robots_follow', 1);
        $addInsight->schema_json_ld = $request->schema_json_ld;
        $addInsight->save();
        return redirect('admin/live-insights')->with('message', 'Board Insight Published As Draft!');
    }

    public function liveInsight(Request $request)
    {
        if(isset($_GET['query'])){            
            $search_insight = $_GET['query'];
            $searchInsight = BoardInsights::orderBy('created_at','desc')->where('title', 'LIKE', '%'.$search_insight.'%')->paginate(50);       
            $searchInsight->appends($request->all());
        }else{
            $searchInsight = BoardInsights::orderBy('created_at','desc')->paginate(50);
        }
        return view('admin.liveInsight', ['searchInsight'=>$searchInsight]);
    }

    public function editInsight($id)
    {
        $editInsight = BoardInsights::findOrFail($id);
        return view('admin.editInsight', [
            'editInsight' => $editInsight,
        ]);
    }

    public function updateInsight(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'slug'    => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'nullable|in:0,1',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:1000',
            'canonical_url' => 'nullable|string|max:255',
            'og_image' => 'nullable|string|max:255',
            'robots_index' => 'nullable|in:0,1',
            'robots_follow' => 'nullable|in:0,1',
            'schema_json_ld' => 'nullable|string',
        ]);

        $updateInsight = BoardInsights::findOrFail($id);
        $updateInsight->title = $request->title;
        $updateInsight->slug = $request->slug;
        $updateInsight->content = $request->content;
        $updateInsight->status = $request->status;
        $updateInsight->meta_title = $request->meta_title;
        $updateInsight->meta_description = $request->meta_description;
        $updateInsight->meta_keywords = $request->meta_keywords;
        $updateInsight->canonical_url = $request->canonical_url;
        $updateInsight->og_image = $request->og_image;
        $updateInsight->robots_index = $request->input('robots_index', 1);
        $updateInsight->robots_follow = $request->input('robots_follow', 1);
        $updateInsight->schema_json_ld = $request->schema_json_ld;
        $updateInsight->save();
        return redirect('admin/live-insights')->with('message', 'Board Insight Successfully Updated!');
    }

    public function deleteInsight($id)
    {
        $deleteInsight = BoardInsights::findOrFail($id);
        $deleteInsight->delete();
        return redirect('admin/live-insights')->with('message', 'Board Insight Successfully Deleted!');
    }

    public function insightList()
    {
        $insightList = BoardInsights::where('status', 1)->orderByDesc('created_at')->paginate(8);
        $insightList->setCollection(
            $insightList->getCollection()->map(fn ($item) => $this->decorateInsightPreview($item))
        );

        return view('front.insightList', [
            'insightList' => $insightList,
            'banner' => PageBanner::forKey('board_insights'),
        ]);
    }

    public function insightDetails($slug)
    {
        $insightDetails = BoardInsights::where([['slug', $slug], ['status', 1]])->first();
        
        if(is_null($insightDetails)){
            return response()->view('errors.404', [], 404);
        }

        $plainText = strip_tags($insightDetails->content);
        $wordCount = str_word_count($plainText);
        $wordsPerMinute = 175;
        $readingTime = (int) ceil($wordCount / $wordsPerMinute);

        $htmlContent = $insightDetails->content;
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

        $related = BoardInsights::where([['slug', '!=', $slug], ['status', 1]])->limit(7)->get();
        return view('front.insightDetails', [
            'insightDetails' => $insightDetails,
            'related' => $related,
            'readingTime' => $readingTime,
            'htmlContent' => $htmlContent,
            'tableOfContents' => $tableOfContents,
            'seo' => [
                'title' => $insightDetails->meta_title ?: $insightDetails->title,
                'description' => $insightDetails->meta_description ?: Str::limit($plainText, 155),
                'keywords' => $insightDetails->meta_keywords,
                'canonical' => $insightDetails->canonical_url ?: url('board-insights/' . $insightDetails->slug),
                'image' => $this->publicAssetUrl($insightDetails->og_image, asset('img/site-banner.jpg')),
                'robots' => $this->robotsContent((bool) ($insightDetails->robots_index ?? true), (bool) ($insightDetails->robots_follow ?? true)),
                'schema' => $insightDetails->schema_json_ld,
            ],
        ]);
    }

    private function decorateInsightPreview(BoardInsights $insight): BoardInsights
    {
        $plainText = html_entity_decode(strip_tags($insight->content), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $plainText = trim(preg_replace('/\s+/u', ' ', $plainText));
        $wordCount = str_word_count($plainText);

        $insight->excerpt = Str::limit($plainText, 170);
        $insight->reading_time = max(1, (int) ceil($wordCount / 175));

        return $insight;
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
