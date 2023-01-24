<?php

namespace App\Http\Controllers;

use App\User;
use App\UserSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function verify(Request $request){
        $id = $request->input('id');
        $user = User::find($id);
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();

        return back();
    }

    public function delete(Request $request){
        $id = $request->input('id');
        $user = User::find($id);
        $user->delete();
        $userSection = UserSection::find($id);
        $userSection->delete();

        return back();
    }
}
