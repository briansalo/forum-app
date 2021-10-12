@extends('layouts.app')

@section('content')

    <div class="card mb-5">
         <div class="card-header">
         	<div class="d-flex justify-content-between">
         		<div>
             		{{$discussion->author->name}}
                    <b>({{number_format($discussion->author->points)}} points)</b>
             	</div>      
                @auth 
                @if(auth()->user()->id == $discussion->user_id)
                @else
                    @if($discussion->is_been_watched_by_user())
                        <div>
                           <a href="{{ route('unwatch.discussion',['discussion' => $discussion->id])}}"class="btn btn-info">
                            Unwatch
                            </a>
                        </div>
                    @else
                        <div>
                           <a href="{{ route('watch.discussion',['discussion' => $discussion->id])}}"class="btn btn-info">
                            watch
                            </a>
                        </div>
    	            @endif
                 @endif   
                @endauth
         	</div>
         </div>
          <div class="card-body">
            <strong> {{$discussion->title}}</strong>
             {!! $discussion->content !!}
          </div>
    </div>

<!-- E CHECK KUNG ang sa discussion table kung empty ba ang sa reply_id kay kung dili siya empty mo proceed neng akong statement.  aron malikayan ang error sa mga condition dere kay ang uban condition dere nag basi ne siya sa mga id sa bestreply. then ang else ane kay e retrieve ra niya tanan mga g pang reply --> 
 @if(!empty($discussion->getbestReply->id))
    <!-- Close -->    
    @foreach($discussion->replies()->paginate(3) as $reply)
        @if($discussion->getbestReply->id == $reply->id)
        <div class="card text-white bg-primary mb-5">  
         @else
         <div class="card mb-5">
         @endif   
         <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    {{$reply->owner->name}}
                    <b>({{number_format($reply->owner->points)}} points)</b>
                </div>
                 <div>
            @if($discussion->getbestReply->id == $reply->id)
                    BEST REPLY
              @elseif(auth()->user() && auth()->user()->id == $discussion->user_id)
                <form action="{{ route('discussion.best-reply', ['discussion' => $discussion->slug, 'reply' =>$reply->id])}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm mb-2">
                        Mark as Best Reply
                    </button>                     
                </form>
             @endif     
                </div>
            </div>
         </div>

          <div class="card-body">
             {!! $reply->content !!}
             @if($discussion->getbestReply)
             @endif
          </div>
    </div>
    @endforeach

 @else
 
  @foreach($discussion->replies()->paginate(3) as $reply)
        <div class="card mb-5">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <div>
                    {{$reply->owner->name}}
                    <b>({{number_format($reply->owner->points)}} points)</b>
                </div>
                 <div>
              @if(auth()->user()->id == $discussion->user_id)
                <form action="{{ route('discussion.best-reply', ['discussion' => $discussion->slug, 'reply' =>$reply->id])}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm mb-2">
                        Mark as Best Reply
                    </button>                     
                </form>
             @endif     
                </div>
            </div>
         </div>

          <div class="card-body">
             {!! $reply->content !!}
          </div>
    </div>
    @endforeach
 @endif   
 {{$discussion->replies()->paginate(3)->links()}}




     <div class="card">
         <div class="card-header">
                <div>
                    <strong>Add a Reply</strong>
                </div>
         </div>

          <div class="card-body">
            @auth
             <!-- "OPEN" discussion slug ang atong basehan. total sa database ang slug kay naka unique man so mura ra gihapon siyag i.d. kay unique -->
                 <form action="{{ route('replies.store', ['discussion' => $discussion->slug])}}"  method="POST">
                  @csrf
                   <!-- Close-->
                    <div class="form-group">
                        <label for="content">Content</label>
                        <input id="content" type="hidden" name="content">
                        <trix-editor input="content"> </trix-editor>
                    </div>
                     <button type="submit" class="btn btn-success">
                        Add a reply
                    </button>     
                 </form> 
            @else
                <a href="{{ route('login')}}"class="btn btn-info">
                     Sign in to add a reply
                </a> 
            @endauth  
          </div>
    </div>
    <br>         
@endsection

@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">

@endsection



@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>

@endsection