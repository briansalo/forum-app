<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discussion;
class UsersController extends Controller
{
    public function notification()
    {
    	//dd(auth()->user()->notifications->first()->data['discussion']['slug']);  gamit ne aron makuha gyod ang slug
    	

 			return view('users.notification')
 			->with('allnotification', auth()->user()->notifications);
 
    }

}
