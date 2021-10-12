@extends('layouts.app')

@section('content')

@foreach($discussions as $discussion)
    <div class="card">
         <div class="card-header">
         	<div class="d-flex justify-content-between">
         		<div>
                    <img width="40px" height="40px" class="rounded-circle" src="{{ Gravatar::src($discussion->author->email) }}" alt="" >
             		{{$discussion->author->name}} 
                    <b>({{number_format($discussion->author->points)}} points)</b>
             	</div>
             	<div>
             		<a href="{{ route('discussions.show', $discussion->slug)}}" class="btn btn-success btn-sm">View</a>
             	</div>	
         	</div>
         </div>

          <div class="card-body">
          	<div class="mr-5">
	             <strong>
	             	{{ $discussion->title }}
	             </strong>
         	</div>
          </div>
    </div>
    <br>

@endforeach  
    {{$discussions->links()}}          
@endsection
