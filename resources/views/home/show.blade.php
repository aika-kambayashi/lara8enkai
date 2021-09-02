@extends('layouts.default')

@section('title', 'Order.show')

@include('layouts.menu.default')

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
        <th scope="col">id</th>
        <th scope="col">イベント名</th>
        <th scope="col">最大参加人数</th>
        <th scope="col">カテゴリ</th>
        <th scope="col">登録ユーザ名</th>
        <th scope="col">最終更新日時</th>
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
    <tr bgcolor="#3490dc"><th><font color="#ffffff">現在の参加者数</font></th></tr>
    <tr><td>{{count($event->event_users)}}</td></tr>
</table>
<p align="center">
    <a class="btn btn-primary" href="{{route('admin.event.show', $event->id)}}">ログインする</a>
</p>
@endsection