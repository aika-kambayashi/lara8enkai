<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\User;
use App\Models\EventUser;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $events = Event::sortable()->simplePaginate(5);
        return view('home.index', compact('events'));
    }

    public function show($id){
        $event = Event::find($id);
        $eventuser_count = EventUser::where('event_id', $event->id)->count();
        return view('home.show', compact('event', 'eventuser_count'));
    }
}
