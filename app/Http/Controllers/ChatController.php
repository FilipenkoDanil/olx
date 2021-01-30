<?php

namespace App\Http\Controllers;

use App\Events\MessagesEvent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $users = DB::select("select users.id, users.name, users.avatar, users.email, count(is_read) as unread
        from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
        where users.id in (select messages.from as users from messages where messages.from in (select distinct messages.from from messages where messages.from = " . Auth::id() . " or messages.to = " . Auth::id() . ")
        UNION select messages.to as users from messages where messages.to in (select distinct messages.to from messages where messages.from = " . Auth::id() . " or messages.to = " . Auth::id() . "))
        group by users.id, users.name, users.avatar, users.email");


        return view('messages.home', compact('users'));
    }


    public function getMessage($user_id)
    {
        $my_id = Auth::id();
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
        })->orWhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id);
        })->get();

        return view('messages.index', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();

        event(new MessagesEvent($data));


        return redirect()->route('messages');
    }

}
