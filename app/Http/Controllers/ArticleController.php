<?php

namespace App\Http\Controllers;

use Cart;
use App\Pic;
use App\Article;
use App\Popular;
use Illuminate\Http\Request;
use App\Imports\ArticlesImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'article_code' => 'required',
            'category' => 'required',
            'group' => 'required',
            'family' => 'required',
            'fam_desc' => 'required',
            'price' => 'required',
            'valid' => 'required',
            'stock' => 'required',
            'lead_time' => 'required',
            'desc_eng' => 'required',
        ]);

        $article = new Article;
        $article->article_code = $request->article_code;
        $article->category = $request->category;
        $article->group = $request->group;
        $article->family = $request->family;
        $article->fam_desc = $request->fam_desc;
        $article->price = $request->price;
        $article->valid = $request->valid;
        $article->unit = $request->unit;
        $article->weight = $request->weight;
        $article->volume = $request->volume;
        $article->stock = $request->stock;
        $article->lead_time = $request->lead_time;
        $article->desc_eng = $request->desc_eng;
        $article->desc_fra = $request->desc_fra;
        $article->desc_spa = $request->desc_spa;
        $article->details = $request->details;
        $article->save();
        
        Session::flash('success', 'Upload was successful');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $article_code
     * @return \Illuminate\Http\Response
     */
    public function show($article_code)
    {
        $article = Article::where('article_code', $article_code)->first();
        // if (session()->has('currency')) {
        //     $usd = session()->get('KES_USD');
        //     $eur = session()->get('KES_EUR');
        //     $chf = session()->get('KES_CHF');
        //     if (session()->get('currency') == 'usd') {
        //         $article->price *= $usd;
        //     }
        //     elseif (session()->get('currency') == 'eur') {
        //         $article->price *= $eur;
        //     }
        //     elseif (session()->get('currency') == 'chf') {
        //             $article->price *= $chf;
        //     }  
        // }
        return view('item')->with(['active' => '', 'article' => $article]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $article_code
     * @return \Illuminate\Http\Response
     */
    public function edit($article_code)
    {
        $article = Article::where('article_code', $article_code)->first();
        return view('add')->with(['active' => '', 'article' => $article, 'det' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $article_code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $article_code)
    {
        $request->validate([
            'article_code' => 'required',
            'category' => 'required',
            'group' => 'required',
            'family' => 'required',
            'fam_desc' => 'required',
            'price' => 'required',
            'valid' => 'required',
            'stock' => 'required',
            'lead_time' => 'required',
            'desc_eng' => 'required',
        ]);

        $article = Article::where('article_code', $article_code)->first();
        $article->article_code = $request->article_code;
        $article->category = $request->category;
        $article->group = $request->group;
        $article->family = $request->family;
        $article->fam_desc = $request->fam_desc;
        $article->price = $request->price;
        $article->valid = $request->valid;
        $article->unit = $request->unit;
        $article->weight = $request->weight;
        $article->volume = $request->volume;
        $article->stock = $request->stock;
        $article->lead_time = $request->lead_time;
        $article->desc_eng = $request->desc_eng;
        $article->desc_fra = $request->desc_fra;
        $article->desc_spa = $request->desc_spa;
        $article->details = $request->details;
        $article->save();
        
        Session::flash('success', 'Upload was successful');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $article_code
     * @return \Illuminate\Http\Response
     */
    public function destroy($article_code)
    {
        //dd($article_code);
        $article = Article::where('article_code', $article_code)->first();
        $pics = $article->pic;
        foreach ($pics as $pic) {
            Storage::delete('public/mbotos/'.$pic->pic);
            $pic->delete();
        }
        $article->delete();
        Session::flash('success', 'Delete was successful');

        return back();
    }

    //upload pictures
    public function uploadPics(Request $request){
        if($request->hasFile('qqfile') && $request->session()->has('article_code')){
            if ($request->session()->has('det') && !$request->session()->has('picsin')) {
                $article = Article::where('article_code', $request->session()->get('article_code'))->first();
                $pics = $article->pic;
                foreach ($pics as $pic) {
                    Storage::delete('public/mbotos/'.$pic->pic);
                    $pic->delete();
                }
                $request->session()->put('picsin');
            }
            $fileExt = $request->file('qqfile')->getClientOriginalExtension();    
            $fileStore = $request->input('qquuid').'.'.$fileExt;
            $path = $request->file('qqfile')->storeAs('public/mbotos', $fileStore);

            $pic = new Pic;
            $pic->article_code = $request->session()->get('article_code');
            $pic->pic = $fileStore;
            $pic->save();

            return response()->json(['success' => true]);
        }
    }

    public function deletePics(Request $request){
        return response()->json(['success' => true]);
    }

    public function import(Request $request){
        Excel::import(new ArticlesImport, $request->file('article'));
        Session::flash('success', 'Upload was successful');
        return back();
    }
}
