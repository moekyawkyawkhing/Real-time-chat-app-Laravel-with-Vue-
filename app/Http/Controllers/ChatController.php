<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;
use Auth;
use App\Message;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('chat');
    }

    public function data(){
        $messages= Message::with('user')->get();
        return response()->json($messages);
    }

    public function store(Request $request){
        $message=Auth::user()->messages()->create([
            'user_id' => Auth::user()->id,
            'message' => $request->get('message')
        ]);
        broadcast(new ChatEvent($message));
        return response()->json('success');
    }
}
