<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\User;
use App\Models\EventUser;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $events = Event::sortable()
                ->simplePaginate(5);
        return view('event.index', compact('events'));
    }

    public function mylist() {
        $userid = \Auth::user()->id;
        $events = Event::where('user_id', $userid)->sortable()->simplePaginate(5);
        return view('event.mylist', compact('events'));
    }

    public function create() {
        $categories = Category::all();
        $users = User::all();
        $current_user = \Auth::user()->id;
        return view('event.create', compact('categories', 'users', 'current_user'));
    }

    public function store(Request $request) {
        $this->validate($request, Event::$rules);
        $event = new Event([
            'name' => $request->input('name'),
            'detail' => $request->input('detail'),
            'max_participant' => $request->input('max_participant'),
            'category_id' => $request->input('category_id'),
            'user_id' => $request->input('user_id'),
        ]);
        if ($event->save()) {
            $request->session()->flash('success', __('イベントを新規登録しました'));
        } else {
            $request->session()->flash('error', __('イベントの新規登録に失敗しました'));
        }

        return redirect()->route('admin.event.index');
    }

    public function show($id) {
        $event = Event::find($id);
        $eventusers = EventUser::where('event_id', $event->id)->orderBy('id', 'desc')->get();
        $userid = \Auth::user()->id;
        
        $flg = false;  
        foreach ($eventusers as $eventuser) {
            if ($userid == $eventuser->user_id) {
                $flg = true;
                break;
            }
        }
        return view('event.show', compact('event', 'eventusers', 'flg'));
    }

    public function edit($id) {
        $event = Event::find($id);
        $categories = Category::all();
        $users = User::all();
        return view('event.edit', compact('event', 'categories', 'users'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, Event::$rules);
        $event = Event::find($id);
        $columns = array_keys(Event::$rules);
        foreach ($columns as $column) {
            $event->$column = $request->input($column);
        }
        if ($event->save()) {
            $request->session()->flash('success', __('イベントを更新しました'));
        } else {
            $request->session()->flash('error', __('イベントの更新に失敗しました'));
        }

        return redirect()->route('admin.event.mylist');
    }

    public function destroy(Request $request, $id) {
        $event = Event::find($id);
        $userid = \Auth::user()->id;
        $eventuser = EventUser::where('event_id', $id)->first();

        if ($event->user_id == $userid) {
            if ($eventuser) {
                $request->session()->flash('error', __('参加者のいるイベントは削除できません'));
            } else {
                $event->delete();
                $request->session()->flash('success', __('イベントを削除しました'));
            } 
        } else {
                $request->session()->flash('error', __('管理しているイベントのみが削除可能です'));
        }

        return redirect()->route('admin.event.mylist');
    }

}