<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Watch;
class WatchesController extends Controller
{

    public function watch($discussion)
    {
    	Watch::create([
    		'user_id' => auth()->user()->id,
    		'discussion_id' => $discussion
    	]);
 		session()->flash('success','you watched this discussion');
 		return redirect()->back();
    }

    public function unwatch($discussion)
    {
    	
    	$watcher =Watch::where('discussion_id', $discussion)->where('user_id', auth()->user()->id);
    	$watcher->delete();

 		session()->flash('success','you unwatched this discussion');
 		return redirect()->back();
    }

}
