<?php


namespace App\ViewComposers;


use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MessagesComposer
{
    public function compose(View $view){
        if(Auth::check()){
            $messages = Message::where('to', Auth::id())->where('is_read', 0)->get();
            $view->with('messages', $messages);
        }
    }
}
