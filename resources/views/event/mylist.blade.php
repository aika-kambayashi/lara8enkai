@extends('layouts.default')

@section('title', 'Event.mylist')

@include('layouts.menu.admin')

@section('content')
@if (session('success'))
<div class="alert alert-success" role="alert">{{session('success')}}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger" role="alert">{{session('error')}}</div>
@endif
<h1 class="page-header">イベント一覧</h1>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <tr>
        <th scope="col">id</th>
        <th scope="col">イベント名</th>
        <th scope="col">最大参加人数</th>
        <th scope="col">現在の参加者数</th>
        <th scope="col">カテゴリ</th>
        <th scope="col">登録ユーザ名</th>
        <th scope="col">最終更新日時</th>
        <th scope="col">アクション</th>
    </tr>
    @foreach ($events as $event)
    <tr>
        <td>{{$event->id}}</td>
        <td>{{$event->name}}</td>
        <td>{{$event->max_participant}}</td>
        <td>{{count($event->event_users)}}</td>  
        <td>{{$event->Category->name}}</td>
        <td>{{$event->User->name}}</td>
        <td>{{$event->updated_at->format('Y年m月d日H時i分')}}</td>
        <td class="actions text-nowrap">
            <a class="btn btn-primary" href="{{route('admin.event.edit', $event->id)}}">編集</a>
            <a class="btn btn-primary" href="{{route('admin.event.destroy', $event->id)}}">削除</a>
        </td>
    </tr>
    @endforeach
</table>
<div class="paginator">
    <ul class="pagination justify-content-center">{{$events->links()}}</ul>
</div>
@endsection