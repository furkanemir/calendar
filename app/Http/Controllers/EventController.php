<?php

namespace App\Http\Controllers;

use App\Models\UserList;
use Illuminate\Http\Request;

use App\Models\Event;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $users = UserList::all();
        return view('calendar', compact('events', 'users'));
    }
    public function store(Request $request)
    {
        $event = new Event();
        $event->user_list_id = $request->user_id;
        $event->title = $request->title;
        $event->description = $request->description;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->save();

        return response()->json(['status' => 'success', 'event' => $event]);
    }
    public function delete($id)
    {
        Event::destroy($id);
        return response()->json(['status' => 'success']);
    }
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['status' => 'error', 'message' => 'Etkinlik bulunamadı'], 404);
        }
        $event->user_list_id = $request->input('user_id');
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->start = $request->input('start');
        $event->end = $request->input('end');
        $event->save();

        return response()->json(['status' => 'success', 'event' => $event]);
    }

    public function getEventsByUser(Request $request)
    {
        $userId = $request->query('user_id');

        if ($userId && $userId !== 'all') {
            $events = Event::where('user_list_id', $userId)->get();
        } else {
            $events = Event::all();
        }

        return response()->json($events);
    }
}
