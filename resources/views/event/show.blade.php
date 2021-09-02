@extends('layouts.default')

@section('title', 'Order.show')

@include('layouts.menu.admin')

@section('content')
<h1 class="page-header">イベント表示</h1>
@if (session('success'))
<div class="alert alert-success" role="alert">{{session('success')}}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger" role="alert">{{session('error')}}</div>
@endif
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <tr>
        <th scope="col">@sortablelink('event.id', __('id'))</th>
        <th scope="col">@sortablelink('event.name', __('イベント名'))</th>
        <th scope="col">@sortablelink('event.max_participant', __('最大参加人数'))</th>
        <th scope="col">@sortablelink('category.name', __('カテゴリ'))</th>
        <th scope="col">@sortablelink('user.name', __('登録ユーザ名'))</th>
        <th scope="col">@sortablelink('events.updated_at', __('最終更新日時'))</th>
    </tr>
    <tr>
        <td>{{$event->id}}</td>
        <td>{{$event->name}}</td>
        <td>{{$event->max_participant}}</td>
        <td>{{$event->Category->name}}</td>
        <td>{{$event->User->name}}</td>
        <td>{{$event->updated_at->format('Y年m月d日H時i分')}}</td>
    </tr>
</table>

<table class="table-count" cellpadding="0" cellspacing="0">
    <tr><th>現在の参加者数</th></tr>
    <tr><td>{{count($event->event_users)}}</td></tr>
</table>

<h1 class="page-header">イベント参加者</h1>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <tr>
        <th scope="col">@sortablelink('user.id', __('ユーザID'))</th>
        <th scope="col">@sortablelink('user.name', __('ユーザ名'))</th>
        <th scope="col">@sortablelink('event.updated_at', __('登録日時'))</th>
    </tr>
    @foreach ($eventusers as $eventuser)
    <tr>
        <td>{{$eventuser->user_id}}</td>
        <td>{{$eventuser->User->name}}</td>
        <td>{{$eventuser->created_at->format('Y年m月d日H時i分')}}</td>
    </tr>
    @endforeach
</table>
    
<p align="center">
    @if ($flg)
        <a class="btn btn-primary" href="{{route('admin.chat.talk', $event->id)}}">チャットに参加する</a> 
        <a class="btn btn-primary" href="{{route('admin.eventuser.destroy', $event->id)}}">このイベントから辞退する</a>
    @else
        <a class="btn btn-primary" href="{{route('admin.eventuser.store', $event->id)}}">このイベントに参加する</a>
    @endif
</p>

@endsection