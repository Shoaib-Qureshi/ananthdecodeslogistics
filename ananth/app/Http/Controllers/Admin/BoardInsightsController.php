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

class BoardInsightsController extends Controller
{
    public function createInsight()
    {
        return view('admin.createInsight');
    }

    public function saveInsight(Request $request)
    {
        $addInsight = new BoardInsights();
        $addInsight->title = $request->title;
        $addInsight->slug = Str::slug($request->input('title'));
        $addInsight->content = $request->content;
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
        $editInsight = BoardInsights::find($id);
        return view('admin.editInsight', [
            'editInsight' => $editInsight,
        ]);
    }

    public function updateInsight(Request $request, $id)
    {
        $updateInsight = BoardInsights::find($request->id);
        $updateInsight->title = $request->title;
        $updateInsight->slug = $request->slug;        
        $updateInsight->content = $request->content;
        $updateInsight->status = $request->status;
        $updateInsight->save();
        return redirect('admin/live-insights')->with('message', 'Board Insight Successfully Updated!');
    }

    public function deleteInsight($id)
    {
        $deleteInsight = BoardInsights::find($id);
        $deleteInsight->delete();
        return redirect('admin/live-insights')->with('message', 'Board Insight Successfully Deleted!');
    }

    public function insightList()
    {
        $insightList = BoardInsights::where('status', 1)->orderBy('id', 'desc')->paginate(9);
        return view('front.insightList', [
            'insightList' => $insightList,
        ]);
    }

    public function insightDetails($slug)
    {
        $insightDetails = BoardInsights::where([['slug', $slug], ['status', 1]])->first();
        
        if(is_null($insightDetails)){
            return view('errors.404');
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
        ]);
    }
}
