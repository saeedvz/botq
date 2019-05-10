<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $keywords = $request->user()->keywords()->orderBy('id', 'desc')->paginate(15);

        return view('panel.keywords.index')
            ->with([
                'pageTitle' => __('Keywords'),
                'keywords' => $keywords
            ]);
    }

    public function add(Request $request)
    {
        $rules = [
            'keyword' => 'required',
        ];
        $this->validate($request, $rules);

        $request->user()->keywords()->create([
            'keyword' => $request->keyword,
            'replace' => $request->replace,
        ]);

        return redirect()->back()
            ->with([
                'alert' => 'success',
                'message' => __('Added')
            ]);
    }

    public function delete(Request $request)
    {
        $rules = [
            'id' => 'required|exists:keywords,id,user_id,' . $request->user()->id,
        ];
        $this->validate($request, $rules);

        $request->user()->keywords()->where('id', '=', $request->id)->delete();

        return redirect()->back()
            ->with([
                'alert' => 'success',
                'message' => __('Deleted')
            ]);
    }
}
