<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 180);

use Mail;
use Illuminate\Http\Request;
use App\Exports\KsuUfExport;
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
            $m->bcc('MSFOCB-KSU-it@brussels.msf.org');
            if ($data['attachment'] != "") {
                foreach ($data['attachment'] as $attacho) {
                    $filename = 'attacho_'.time().'.png';
                    $m->attach($attacho, ['as' => $filename]);
                }
            }
        });

        Session::flash('success', 'Email was sent successfully. We will contact you soon and thank you for using our services.');

        return back();
    }

    public function download(Request $request){
        $dwnld = $request->input('dwnld');
        if ($dwnld == "full") {
            return Excel::download(new CatalogExport, 'Full Catalogue.xlsx');
        }
        elseif ($dwnld == "ksu") {
            return Excel::download(new KsuUfExport, 'KSU Catalogue.xlsx');
        }
    }
    public function dwnlds(Request $request){
        $dwnld = $request->input('dwnld');
        if ($dwnld == "tc") {
            if (Session::get('language') == "fr") {
                $file = "files/Kenya Supply Unit-Conditions-Generales_Francais.pdf";
            } else {
                $file = "files/Kenya Supply Unit-Terms-of-Conditions.pdf";
            }
            return response()->download(public_path($file));
        }
        elseif ($dwnld == "gpc") {
            $file = "files/KSU General Purchase Conditions.pdf";
            return response()->download(public_path($file));
        }
        // elseif ($dwnld == "job1") {
        //     $file = "files/Advert Procurement Officer_July 2020.pdf";
        //     return response()->download(public_path($file));
        // }
        // elseif ($dwnld == "job2") {
        //     $file = "files/Advert  Customer Service Officer_July 2020.pdf";
        //     return response()->download(public_path($file));
        // }
    }

    public function downloadTransport(){
        $file = "files/KSU Regional Transport  Rates.xlsx";
        return response()->download(public_path($file));
    }

    public function downloadCovid(){
        $file = "files/Kenya import and export update.docx";
        return response()->download(public_path($file));
    }
}
