@extends('layouts.default')

@section('title', 'Chat.talk')

@include('layouts.menu.admin')

@section('content')

<div class="box"><h1 class="page-header">{{$event->name}}</h1></div>
@if (session('success'))
<div class="alert alert-success" role="alert">{{session('success')}}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger" role="alert">{{session('error')}}</div>
@endif
<form action="{{route('admin.chat.store', $event->id)}}" method="post">
<input type="hidden" id="chat" name="user_id" value="{{$userid}}" required/>
<input type="hidden" id="chat" name="event_id" value="{{$event->id}}" required/>
    @csrf
    
    @foreach ($chats as $chat)
        <div class="box">
        @if ($chat->user_id == $userid)
            <table class="table-user">
                <tr><td>{{$chat->User->name}}</td></tr>
                <tr><td>{{$chat->body}}</td></tr>
                <tr><td>{{$chat->created_at->format('Y年m月d日H時i分')}}</td></tr>
            </table>
        @else
            <table class="table-otheruser">
                <tr><td>{{$chat->User->name}}</td></tr>
                <tr><td>{{$chat->body}}</td></tr>
                <tr><td>{{$chat->created_at->format('Y年m月d日H時i分')}}</td></tr>
            </table>
        @endif
</div>
    @endforeach

<table class="table-count" cellpadding="0" cellspacing="0">
    <tr><th>投稿</th></tr>
    <tr>
        <td>
        <div class="form-group">
            <label for="body">投稿</label>
            <input class="form-control" type="text" name="body" value="{{old('body')}}" required>
        </div>
        <div class="form-group">
            <input class="btn btn-light" type="submit" value="投稿">
        </div>
        </td>
    </tr>

</table>

@endsection