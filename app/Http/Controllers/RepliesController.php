<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateReplyRequest;
use App\Notifications\NewReplyAdded;
use App\Watch;
use App\Discussion;
use App\User;
use Notification;

class RepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReplyRequest $request, Discussion $discussion)
    {


        auth()->user()->replies()->create([
            'content' => $request->content,
            'discussion_id' => $discussion->id
        ]);

        $point = User::find(auth()->user()->id);
        $point->points +=  25;
        $point->save();

            // naay explnation ane sa discussion.php
       $watchers_id = array();
            foreach($discussion->watches as $watch):
                array_push($watchers_id, User::find($watch->user->id));// then derea nag user::find ta aron ang e retrieve ane kay ang collection sa user it means ang general info sa user aron sab malikayan ang error kay sa notification documentation gameton ra daw nako ang send method which is this"Notification::send" kung mag send kog notification to multiple such as collection of users
            endforeach;
            Notification::send($watchers_id, new NewReplyAdded($discussion));
        
            $discussion->author->notify(new NewReplyAdded($discussion));

        session()->flash('success','Discussion Posted');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
