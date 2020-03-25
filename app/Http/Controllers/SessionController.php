<?php

namespace App\Http\Controllers;

use App\Pic;
use App\Article;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    //set language
    public function language(Request $request){
        $lan = $request->input('lan');
        if($lan == "en"){
            $request->session()->put('language', $lan);
            return back();
        }
        elseif($lan == "fr"){
            $request->session()->put('language', $lan);
            return back();
        }
        elseif ($lan == "es") {
            $request->session()->put('language', $lan);
            return back();
        }
    }

    //set currency
    public function currency(Request $request){
        if(!session()->has('rates')){
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://free.currconv.com/api/v7/convert?q=KES_USD,KES_EUR,KES_CHF&compact=ultra&apiKey=e1d068c795b62617f12a');
            // curl_setopt($ch, CURLOPT_POST, 0);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // $response = curl_exec ($ch);
            // $err = curl_error($ch);  //if you need
            // curl_close ($ch);
            // $obj = json_decode($response, true);
            // session()->put('KES_USD', $obj['KES_USD']);
            // session()->put('KES_EUR', $obj['KES_EUR']);
            // session()->put('KES_CHF', $obj['KES_CHF']);
            session()->put('KES_USD', 0.0094);
            session()->put('KES_EUR', 0.0087);
            session()->put('KES_CHF', 0.0092);
            session()->put('rates', 'ok');
        }

        $curr = $request->input('curr');
        if($curr == "ksh"){
            $request->session()->put('currency', $curr);
            return back();
        }
        elseif($curr == "usd"){
            $request->session()->put('currency', $curr);
            return back();
        }
        elseif($curr == "eur"){
            $request->session()->put('currency', $curr);
            return back();
        }
        elseif($curr == "chf"){
            $request->session()->put('currency', $curr);
            return back();
        }
    }

    public function uploadImages(Request $request){
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

        $det = $request->input('det');
        if(isset($det)){
            $request->session()->put('det', $det);
        }
        $request->session()->put('article_code', $request->article_code);
        $request->session()->put('category', $request->category);
        $request->session()->put('group', $request->group);
        $request->session()->put('family', $request->family);
        $request->session()->put('fam_desc', $request->fam_desc);
        $request->session()->put('price', $request->price);
        $request->session()->put('valid', $request->valid);
        $request->session()->put('unit', $request->unit);
        $request->session()->put('weight', $request->weight);
        $request->session()->put('volume', $request->volume);
        $request->session()->put('stock', $request->stock);
        $request->session()->put('lead_time', $request->lead_time);
        $request->session()->put('desc_eng', $request->desc_eng);
        $request->session()->put('desc_fra', $request->desc_fra);
        $request->session()->put('desc_spa', $request->desc_spa);
        $request->session()->put('details', $request->details);

        return view('images')->with('active', '');
    }

    public function upload(Request $request){
        if ($request->session()->has('det')) {
            $article = Article::where('article_code', $request->session()->get("article_code"))->first();
            $request->session()->forget('det');
            $request->session()->forget('picsin');
        } else {
            $article = new Article;
        }
        $article->article_code = $request->session()->get("article_code");
        $article->category = $request->session()->get("category");
        $article->group = $request->session()->get("group");
        $article->family = $request->session()->get("family");
        $article->fam_desc = $request->session()->get("fam_desc");
        $article->price = $request->session()->get("price");
        $article->valid = $request->session()->get("valid");
        $article->unit = $request->session()->get("unit");
        $article->weight = $request->session()->get("weight");
        $article->volume = $request->session()->get("volume");
        $article->stock = $request->session()->get("stock");
        $article->lead_time = $request->session()->get("lead_time");
        $article->desc_eng = $request->session()->get("desc_eng");
        $article->desc_fra = $request->session()->get("desc_fra");
        $article->desc_spa = $request->session()->get("desc_spa");
        $article->details = $request->session()->get("details");
        $article->save();
        
        Session::flash('success', 'Upload was successful');

        return redirect('/add-item');
    }

    public function list(Request $request){
        $request->session()->put('list', $request->input('list'));
        return back();
    }

    public function notShowPics(){
        Session::put('pics', 'disabled');
        return back();
    }

    public function showPics(){
        Session::put('pics', 'enabled');
        return back();
    }
}
