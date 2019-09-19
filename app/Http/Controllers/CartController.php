<?php

namespace App\Http\Controllers;

use PDF;
use Cart;
use Mail;
use App\Exports\IrExport;
use App\Exports\RfqExport;
use Illuminate\Http\Request;
use App\Exports\UnifieldExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function carting(Request $request){
        $article_code = $request->input("article_code");
        $quantity = $request->input("quantity");
        $price = $request->input("price");
        $name = $request->input("name");
        $fra = $request->input("fra");
        $esp = $request->input("esp");
        $pic = $request->input("pic");
        $unit = $request->input("unit");
        $lead_time = $request->input("lead_time");
        $weight = $request->input("weight");
        $volume = $request->input("volume");
        $sud = $request->input("sud");
        Cart::add(array(
            'id' => $article_code,
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price,
            'attributes' => array(
                'fra' => $fra,
                'esp' => $esp,
                'pic' => $pic,
                'comment' => "",
                'unit' => $unit,
                'lead_time' => $lead_time,
                'weight' => $weight,
                'volume' => $volume,
                'sud' => $sud
            )
        ));

        $cart_count = Cart::getContent()->count();

        echo $cart_count;

        // Session::flash('success', 'Item was added to RFQ');

        // return back();
    }

    /**
     * remove the specified resource from cart.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function decarting($id){
        Cart::remove($id);
        return back();
    }

    public function clear(){
        Cart::clear();
        return back();
    }

    public function update(Request $request){
        //dd(Cart::getContent());
        Cart::update($request->input('article_code'), array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->input('quantity')
            ),
            'attributes' => array(
                'comment' => $request->input('comment'),
                'fra' => $request->input('fra'),
                'esp' => $request->input('esp'),
                'pic' => $request->input('pic'),
                'unit' => $request->input('unit'),
                'lead_time' => $request->input('lead_time'),
                'weight' => $request->input('weight'),
                'volume' => $request->input('volume'),
                'sud' => $request->input('sud')
            )
        ));

        Session::flash('success', 'Update was successfull');

        return back();
    }

    public function exportUf(){
        // $items = Cart::getContent();
        // foreach ($items as $item) {
        //     $popular = new Popular;
        //     $exist = Popular::where('article_code', $item->id)->first();
        //     if ($exist == "") {
        //         $popular->article_code = $item->id;
        //         $popular->orders = 1;
        //         $popular->save();
        //     } else {
        //         //dd($exist->orders);
        //         $exist->orders += 1;
        //         $exist->save();
        //     }
        // }
        return Excel::download(new UnifieldExport, 'Unifield_import.xlsx');
    }

    public function exportIr(Request $request){
        $ref_no = time();
        $info = array(
            'name' => $request->input('name'),
            'position' => $request->input('position'),
            'purpose' => $request->input('purpose'),
            'description' => $request->input('description'),
            'destination' => $request->input('destination'),
            'delivery' => $request->input('delivery'),
            'rdd' => $request->input('rdd'),
            'pic' => $request->input('pic'),
            'date' => date("d/m/Y"),
            'ref_no' => $ref_no
        );
        //dd($request->input('pic'));
        $items = Cart::getContent();
        //return view('exports.ir')->with(['info' => $info, 'items' => $items]);
        $pdf = PDF::loadView('exports.ir', ['info' => $info, 'items' => $items])->setPaper('a4', 'landscape');
        $filename = 'ir_'.$ref_no.'.pdf';
        return $pdf->download($filename);
    }

    public function exportRfq(Request $request){
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
        ]);
        $data = array(
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'info' => $request->input('info'),
        );
        Mail::send('emails.rfq', ['items' => Cart::getContent(), 'data' => $data], function ($m) {
            //dd($path);
            $m->from(auth()->user()->email, 'KSU');
            $m->to('MSFOCB-KSU-CustomerService@brussels.msf.org', 'David')->subject('Request for quotation');
            $filename = 'rfq_'.time().'.xlsx';
            $m->attach(Excel::download(new RfqExport, $filename)->getFile(), ['as' => $filename]);
        });

        Session::flash('success', 'Email was sent successfully. We will contact you soon and thank you for using our services.');

        return back();
    }
}
