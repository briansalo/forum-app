@extends('layouts.app')

@section('content')


    <div class="card">
         <div class="card-header">
         	<div class="d-flex justify-content-between">
         		<div>

             	</div>
             	<div>

             	</div>	
         	</div>
         </div>

          <div class="card-body">
            <ul class="list-group">
                @foreach($allnotification as $notifications)

                   @if($notifications->type == 'App\Notifications\NewReplyAdded')
                        <li class="list-group-item">
                            A new reply was added to your discussion
                           <strong> {{$notifications->data['discussion']['title']}}</strong>
                        @if($notifications->read_at =='')
                            <a href="{{ route('discussion.notification', $notifications->data['discussion']['slug'] )}}" class="btn btn-success btn-sm float-right">
                                View Discussion                               
                            </a>
                         @else   
                            <a href="{{ route('all.indexNotification', $notifications->data['discussion']['slug'] )}}" class="btn btn-info btn-sm float-right">
                                View Discussion                               
                            </a>
                        </li>
                        @endif
                    @endif
                            
                  @if($notifications->type == 'App\Notifications\ReplyMarkedBestReply')
                        <li class="list-group-item">
                            your reply was marked as best reply
                           <strong> {{$notifications->data['BestReply']['title']}}</strong>
                       <!-- kane nga button para rane siya sa notification nga wala pa na read. ang kaneng read_at makita nimo ne sa notification table kay aron kung ma sure gyod nga ang mga wala pa na read ang e view ane once e click ang button -->    
                        @if($notifications->read_at =='')
                            <a href="{{ route('bestreply.notification', $notifications->data['BestReply']['slug'] )}}" class="btn btn-success btn-sm float-right">
                                View Discussion                               
                            </a>
                           <!-- close --> 
                         @else   
                            <a href="{{ route('all.indexNotification', $notifications->data['BestReply']['slug'] )}}" class="btn btn-info btn-sm float-right">
                                View Discussion                               
                            </a>
                        </li>
                        @endif
                        
                   @endif     
                 @endforeach   
             </ul>    
          </div>
    </div>
    <br>

   
@endsection
