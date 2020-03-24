<?php

namespace App\Http\Controllers;

use App\Story;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class StoryController extends Controller
{
    public function upload(Request $request){
        $request->validate([
            'story' => 'required',
            'date' => 'required',
            'time' => 'required'
        ]);

        $story = new Story;
        if ($story == "") {
            $story->details = $request->story;
            $story->date = $request->date;
            $story->time = $request->time;
            $story->save();
        } else {
            Story::truncate();
            $story->details = $request->story;
            $story->date = $request->date;
            $story->time = $request->time;
            $story->save();
        }
        
        Session::flash('success', 'Upload was successful');

        return back();
    }
}
