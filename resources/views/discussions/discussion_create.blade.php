@extends('layouts.app')

@section('content')
            <div class="card">
                <div class="card-header">Add Discussion</div>

                <div class="card-body">
                    <form action="{{route('discussions.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" value="">
                        </div> 
                        <div class="form-group">
                            <label for="content">Content</label>
                            <input id="content" type="hidden" name="content">
                            <trix-editor input="content"> </trix-editor>
                        </div>
                        <div class="form-group">
                            <label for="channel">Channel</label>
                            <select name="channel" class="form-control" id="channel">
                                @foreach($channels as $channel)
                                    <option value="{{$channel->id}}">{{$channel->name}}
                                    </option>
                                @endforeach
                             </select>   
                        </div>
                        <button type="submit" class="btn btn-success">Create Discussions</button>     
                    </form>    
            </div>
@endsection

@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">

@endsection



@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>

@endsection