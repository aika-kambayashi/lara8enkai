<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventUser;
use Illuminate\Http\Request;

class EventUserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function store(Request $request, $id) {
        $event = Event::find($id);
        $eventusers = EventUser::where('event_id',$id)->get();       
        $userid = \Auth::user()->id;

        if (count($event->event_users) == $event->max_participant) {
            $request->session()->flash('error', __('最大参加者数に到達しています'));
            return redirect()->route('admin.event.index');
        } else {
            foreach ($eventusers as $eventuser) {
                if ($eventuser->user_id == $userid) {
                    $request->session()->flash('error', __('イベントに参加済みです'));
                    return redirect()->route('admin.event.index');
                }
            }
        }
        $eventuser = new EventUser([
                'event_id' => $event->id,
                'user_id' => $userid,
            ]);
        if ($eventuser->save()) {
            $request->session()->flash('success', __('イベントに参加しました'));
        } else {
            $request->session()->flash('error', __('イベントの参加に失敗しました'));
        }
        return redirect()->route('admin.event.show', $id);        
    }
    
    public function destroy(Request $request, $id) {
        $userid = \Auth::user()->id;
        $eventuser = EventUser::where('event_id', $id)->where('user_id', $userid)->first();
        if ($eventuser) {
            $eventuser->delete();
            $request->session()->flash('success', __('イベントから辞退しました'));
        } else {
            $request->session()->flash('error', __('イベントに参加していません'));
        }

        return redirect()->route('admin.event.show', $id);
    }


}
