<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateDiscussionRequest;
use Illuminate\Support\Str;
use App\Notifications\ReplyMarkedBestReply;

use App\Discussion;
use App\Reply;
use App\User;
use App\Channel;
class DiscussionsController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(request()->path());
       // $data = Discussion::where('channel_id','=',)
         return view('discussions.discussion_index', [
            'discussions' => Discussion::paginate(5)
         ]);
    }

    public function indexchannel(Channel $channel)
    {
       $data = Discussion::where('channel_id','=', $channel->id)->paginate(3);
       //dd($data);
       return view('discussions.discussion_index')->with('discussions', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discussions.discussion_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDiscussionRequest $request)
    {
        // auth()->user()->discussions()->create aron automatic na nga ang e butang sa user_id sa table sa discussion kay ang authentication user. magamit rane siya kay naka relation naman ang user sa discussion
        auth()->user()->discussions()->create([
            'title' =>$request->title,
            'content' =>$request->content,
            'channel_id' =>$request->channel,
             'slug' => Str::slug($request->title)

        ]);

        session()->flash('success','Discussion Posted');
        return redirect()->route('discussions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(discussion $discussion)
    {
      //dd($discussion->getbestReply->id);


        return view('discussions.discussion_show', [
            'discussion' => $discussion
        ]);
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

    public function bestreply(Discussion $discussion, Reply $reply) 
    {
        // $edit = Discussion::find($discussion->slug);
         //$edit->reply_id = $reply->id;
         //$edit->save();

        $data2=$discussion->reply_id;
        $data3=Reply::find($data2);


         $discussion->bestreply($reply); //makita nimo ang explanation nga code ane dedtoa sa model sa disucssion. then pareha rane silag result sa kanang taas nga g hemo nako nga naka comment


         //kung wala pay best reply id sa discussion then ang user e click ang mark as best reply derea siya mo sulod then ang id sa g click nga best reply kay addan og 50 points
       if(is_null($data2)){
                $user = $reply->owner->id;
                $point = User::find($user);
                $point->points +=  50;
                $point->save();
       }
       else{
             if($reply->user_id == $data3->user_id){
             }

             elseif($reply->user_id != $data3->user_id){

                $user = $data3->user_id;
                $point = User::find($user);
                $point->points -=  50;
                $point->save();

                $user = $reply->owner->id;
                $point = User::find($user);
                $point->points +=  50;
                $point->save();
             }

       }


         $reply->owner->notify(new ReplyMarkedBestReply($discussion));

         session()->flash('success','Category Updated Successfully');

        return redirect()->back();
    }


        public function discussionNotification(Discussion $discussion)
    {

        //g gawas tanan ang mga unread nga notification sa auth user ang kanang variable nga $discussion variable gikan na sa web.php nga nag base sa notification.blade.php
        foreach(auth()->user()->unreadNotifications as $notification){

            //nag staement ta derea aron malikayan ang error kay kung tanawon nimo sa database sa notification table naay duha ka klase nga data ang disucssion og bestreply so e check sa nato kung ang type aron ang e for loop niya kay ang type ra nga equal sa atong g statment kay  para sa next statement nato dili mag error kay as you can see nag matter rato siya sa data nga discussion. 
            if($notification->type=='App\Notifications\NewReplyAdded')
            { 

            //kung tanawon nimo sa database ang notification table naay column nga data then sa data kay naka json siya so data['discussion']['slug'] ang gamiton kung gusto nimo e retrieve ang slug sa data nga column.
            //then sa if statement pag ang variable nga notification kay pareha sa $discussion->slug then e mark as read ang kana nga notification                
                if($notification->data['discussion']['slug'] == $discussion->slug)
                {
                  $notification->markAsRead();

                 }
            }    
        }
            //then derea g redirect pa nako siya sa discussion.indexnotification ang purpose ane aron sa frontend ma refresh nako siya kay kung e route view nako ne ang sa front end dili pa dayon mo update ang count sa unreadnotification. kung baga g forward ra nako ang data derea dedtoa sa function indexnotification then dedtoa ra nako g return view.   
 
            return redirect()->route('discussion.indexNotification',
                 ['discussion' => $discussion]); 
        
    }
    public function bestreplyNotification(Discussion $discussion)
    {
           
        // ang explanation ane same ra sa  discussionNotification method sa ibabaw
        foreach(auth()->user()->unreadNotifications as $notification)
        {
                
            if($notification->type=='App\Notifications\ReplyMarkedBestReply')
            {    
                if($notification->data['BestReply']['slug'] == $discussion->slug)
                 {
                    $notification->markAsRead();
                  }
             }
        }

            return redirect()->route('bestreply.indexNotification',
                 ['discussion' => $discussion]); 

}


    public function indexNotification(discussion $discussion)
    {
            return view('discussions.discussion_show', [
            'discussion' => $discussion 
        ]);
    }

}
