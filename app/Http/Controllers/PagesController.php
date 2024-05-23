<?php

namespace App\Http\Controllers;

use Cart;
use App\User;
use App\Story;
use App\Article;
use App\Unicode;
use App\Popular;
use App\UserSection;
use Illuminate\Http\Request;
// use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
// use Illuminate\Pagination\LengthAwarePaginator;

class PagesController extends Controller
{
    // public function __construct(){
    //     $this->middleware('auth', ['except' => ['index', 'about', 'cart', 'catalogue', 'contacts', 'downloads', 'hr', 'item', 'search', 'services', 'hrdeets', 'getfam']]);
    //     $this->middleware('verified', ['except' => ['index', 'about', 'cart', 'catalogue', 'contacts', 'downloads', 'hr', 'item', 'search', 'services', 'hrdeets', 'getfam']]);
    // }

    //view pages
    public function index(){
        return view('index')->with('active', 'home');
    }

    public function about(){
        return view('about')->with('active', 'about');
    }

    public function add(){
        return view('add')->with(['active' => '', 'det' => 'add']);
    }

    public function cart(){
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
        $items = Cart::getContent();
        return view('cart')->with(['active' => '', 'items' => $items]);
    }

    public function catalogue(Request $request){
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
        
        if ($request->session()->has('list')) {
            $list = $request->session()->get('list');
        } else {
            $list = 8;
        }
        
        if ($request->exists('det') || $request->exists('search') || $request->exists('group')) {
            if ($request->has('det')) {
                $det = $request->input('det');
                if ($det == "Med") {
                    $articles = Article::where('category', 'Med')->orderBy('id', 'desc')->paginate($list)->onEachSide(1);
                    $title = "Medical items";
                }
                elseif ($det == "Log") {
                    $articles = Article::where('category', 'Log')->orderBy('id', 'desc')->paginate($list)->onEachSide(1);
                    $title = "Medical items";
                }
                elseif ($det == "New") {
                    $articles = Article::orderBy('id', 'desc')->paginate($list)->onEachSide(1);
                    $title = "Latest items";
                }
                elseif ($det == "Popular") {
                    $populars = Popular::orderBy('orders', 'desc')->paginate($list)->onEachSide(1);
                    //dd($populars->article()->first()->article_code);
                    $arrs = array();
                    foreach ($populars as $popular) {
                        array_push($arrs, $popular->article()->first());
                    }
                    $articles = collect($arrs);
                    $title = "Popular items";
                    //dd($articles);
                    //$articles->paginate($list)->onEachSide(1);
                    // $perPage = 8;
                    // $page = null;
                    // $options = [];
                    // $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    // $articles = $articles instanceof Collection ? $articles : Collection::make($articles);
                    // return new LengthAwarePaginator($articles->forPage($page, $perPage), $articles->count(), $perPage, $page, $options);
                }
            } 
            if ($request->has('search')) {
                $search = $request->get('search');
                if (!$search == "") {
                    $articles = Article::where('article_code', 'like', '%'.$search.'%')
                    ->orWhere('category', 'like', '%'.$search.'%')
                    ->orWhere('group', 'like', '%'.$search.'%')
                    ->orWhere('family', 'like', '%'.$search.'%')
                    ->orWhere('fam_desc', 'like', '%'.$search.'%')
                    ->orWhere('price', 'like', '%'.$search.'%')
                    ->orWhere('unit', 'like', '%'.$search.'%')
                    ->orWhere('sud', 'like', '%'.$search.'%')
                    ->orWhere('weight', 'like', '%'.$search.'%')
                    ->orWhere('volume', 'like', '%'.$search.'%')
                    ->orWhere('lead_time', 'like', '%'.$search.'%')
                    ->orWhere('desc_eng', 'like', '%'.$search.'%')
                    ->orWhere('desc_fra', 'like', '%'.$search.'%')
                    ->orWhere('desc_spa', 'like', '%'.$search.'%')
                    ->orWhere('details', 'like', '%'.$search.'%')
                    ->paginate($list)->onEachSide(1);
                    $title = "All items";
                } else {
                    $articles = Article::paginate($list)->onEachSide(1);
                    $title = "All items";
                }
            }
            if($request->has('group')) {
                $group = $request->input('group');
                $family = $request->input('family');
                if (!$group == "") {
                    if (!$family == "") {
                        $articles = Article::where('group', $group)->where('family', $family)->orderBy('id', 'desc')->paginate($list)->onEachSide(1);
                        $title = "All items";
                    }
                    else {
                        $articles = Article::where('group', $group)->orderBy('id', 'desc')->paginate($list)->onEachSide(1);
                        $title = "All items";
                    }
                } 
                else {
                    $articles = Article::paginate($list)->onEachSide(1);
                    $title = "All items";
                }
            }
        } else {
            $articles = Article::paginate($list)->onEachSide(1);
            $title = "All items";
        }

        $items = Article::orderBy('id', 'desc')->get();
        if (isset($populars)) {
            return view('catalogue')->with(['active' => 'catalogue', 'articles' => $articles, 'items' => $items, 'title' => $title, 'populars' => $populars]);
        } else {
            return view('catalogue')->with(['active' => 'catalogue', 'articles' => $articles, 'items' => $items, 'title' => $title]);
        }
    }

    public function feedback(){
        return view('feedback')->with('active', 'feedback');
    }

    public function contacts(){
        return view('contacts')->with('active', 'contacts');
    }

    public function downloads(){
        return view('downloads')->with('active', 'downloads');
    }

    public function edit(){
        return view('edit')->with('active', '');
    }

    public function hr(){
        return view('hr')->with('active', 'hr');
    }

    public function item(){
        return view('item')->with('active', '');
    }

    public function search(){
        return view('search')->with('active', 'catalogue');
    }

    public function services(){
        return view('services')->with('active', 'services');
    }

    public function favorites(){
        return view('favorites')->with('active', '');
    }

    public function history(){
        return view('history')->with('active', '');
    }

    public function newrequest(){
        return view('newrequest')->with('active', '');
    }

    public function verifyemails(){
        $users = User::where('email_verified_at', null)->get();
        if (count($users) > 0) {
            $user_sects = UserSection::all();
            return view('verifyemails')->with(['active' => '', 'users' => $users, 'user_sects' => $user_sects]);
        }else{
            return view('index')->with('active', 'home');
        }
    }

    public function covid(){
        $stories = Story::all();
        return view('covid')->with(['active' => '', 'stories' => $stories]);
    }

    public function addstory(){
        $stories = Story::all();
        return view('story')->with(['active' => '', 'stories' => $stories]);
    }

    public function hrdeets(Request $request, $deets){
        $deet = $request->input('deet');
        return view('deets')->with(['active' => '', 'deet' => $deet]);
    }

    public function getfam(Request $request){
        $group = $request->input('group');
        $fams = Unicode::where('group', $group)->get();
        return response()->json($fams);
    }

    public function extranet(){
        return view('extranet')->with('active', 'extranet');
    }
    public function pk_overview(){
        return view('pk_overview')->with('active', 'extranet');
    }
    public function tr_overview(){
        return view('tr_overview')->with('active', 'extranet');
    }
    public function bo_monitoring(){
        return view('bo_monitoring')->with('active', 'extranet');
    }
    public function tr_packing(){
        return view('tr_packing')->with('active', 'extranet');
    }
    public function order_confirmation(){
        return view('order_confirmation')->with('active', 'extranet');
    }
    public function pk_view(){
        return view('pk_view')->with('active', 'extranet');
    }
    public function order_view(){
        return view('order_view')->with('active', 'extranet');
    }
    public function freight_view(){
        return view('freight_view')->with('active', 'extranet');
    }
    public function dnno_view(){
        return view('dnno_view')->with('active', 'extranet');
    }
    public function awb_view(){
        return view('awb_view')->with('active', 'extranet');
    }
    public function cmr_view(){
        return view('cmr_view')->with('active', 'extranet');
    }
    public function invoice(){
        return view('invoice')->with('active', 'extranet');
    }
    public function rts(){
        return view('rts')->with('active', 'extranet');
    }
    public function stock(){
        return view('stock')->with('active', 'extranet');
    }
    public function rts_value(){
        return view('rts_value')->with('active', 'extranet');
    }
    public function freight_reception(){
        return view('freight_reception')->with('active', 'extranet');
    }
    public function bt_trace(){
        return view('bt_trace')->with('active', 'extranet');
    }
    public function documents(){
        return view('documents')->with('active', 'extranet');
    }
    public function fior_annex(){
        return view('fior_annex')->with('active', 'extranet');
    }

    public function fior_annexv2(){
        return view('fior_annexV2')->with('active', 'extranet');
    }

    
    public function playground(){
        return view('playground')->with('active', '');
    }
}
