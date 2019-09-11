<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 180);

use Mail;
use Illuminate\Http\Request;
use App\Exports\CatalogExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class AppController extends Controller
{
    public function requestnew(Request $request){
        $request->validate([
            'surname' => 'required',
            'lastname' => 'required',
            'description' => 'required',
            'attachment' => 'max:4096'
        ]);

        $data = array(
            'surname' => $request->input('surname'),
            'lastname' => $request->input('lastname'),
            'article_code' => $request->input('article_code'),
            'description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'budget' => $request->input('budget'),
            'ddate' => $request->input('ddate'),
            'transport' => $request->input('transport'),
            'brand' => $request->input('brand'),
            'specifications' => $request->input('specifications'),
            'website' => $request->input('website'),
            'attachment' => $request->file('attachment')
        );

        Mail::send('emails.newreq', ['data' => $data], function ($m) use ($data) {
            $m->to('MSFOCB-KSU-CustomerService@brussels.msf.org', 'David');
            $m->from('no-reply@ksu.com', 'KSU')->subject('RFQ item not in catalogue');
            // foreach ($data['attachment'] as $pic) {
            //     $m->attach($pic);
            // }
        });

        Session::flash('success', 'Email was sent successfully. We will contact you soon and thank you for using our services.');

        return back();
    }

    public function download(){
        return Excel::download(new CatalogExport, 'Full Catalogue.xlsx');
    }
}
