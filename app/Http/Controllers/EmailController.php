<?php

namespace App\Http\Controllers;

Use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmailController extends Controller
{
    public function requestSupply(Request $request){
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'task' => 'required'
        ]);
        $data = array(
            'name' => $request->input('name'),
            'position' => $request->input('position'),
            'task' => $request->input('task'),
        );
        Mail::send('emails.sup', ['data' => $data], function ($m) {
            //dd($path);
            $m->from(auth()->user()->email, 'KSU');
            $m->to('MSFOCB-KSU-supplychainmanager@brussels.msf.org', 'David')->subject('Request for Supply rights');
            $m->cc('MSFOCB-KSU-it@brussels.msf.org');
        });

        Session::flash('success', 'Email was sent successfully. We will contact you soon and thank you for using our services.');

        return back();
    }
}
