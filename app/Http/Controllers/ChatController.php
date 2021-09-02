<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\User;
use App\Models\EventUser;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function talk(Request $request, $id) {
        $event = Event::find($id);
        $userid = \Auth::user()->id;
        $eventuser = EventUser::where('event_id', $id)->where('user_id', $userid)->first();
        
        if (!$event) {
            $request->session()->flash('error', __('イベントは存在しません'));
            return redirect()->route('admin.event.index');
        } else if (!$eventuser) {
            $request->session()->flash('error', __('イベントに参加していません'));
            return redirect()->route('admin.event.index');
        } else {
            $chats = Chat::where('event_id', $id)->orderBy('updated_at', 'asc')->get();
            return view('chat.talk', compact('chats', 'event', 'userid'));
        }
        
    }

    public function store(Request $request, $id) {
        $this->validate($request, Chat::$rules);
        $event_exist = Event::find($id);
        $userid = \Auth::user()->id;
        $eventuser = EventUser::where('event_id', $id)->where('user_id', $userid)->first();

        if (!$event_exist) {
            $request->session()->flash('error', __('投稿に失敗しました'));
            return redirect()->route('admin.event.index');
        } else if (!$eventuser) {
            $request->session()->flash('error', __('投稿に失敗しました'));
            return redirect()->route('admin.event.index');
        } else {
            $chat = new Chat([
                'user_id' => $request->input('user_id'),
                'event_id' => $request->input('event_id'),
                'body' => $request->input('body'),
            ]);
            if ($chat->save()) {
                $request->session()->flash('success', __('投稿しました'));
            } else {
                $request->session()->flash('error', __('投稿に失敗しました'));
            } 
            
            return redirect()->route('admin.chat.talk', $id);
        }
    }
}
