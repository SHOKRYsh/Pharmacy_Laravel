<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //

    public function sendMessage($sender_id, $receiver_id, Request $request)
    {
        if (!User::find($sender_id) || !User::find($receiver_id)) {
            return response()->json(['message' => "The Sender or Receiver is wrong, check it again"], 400);
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $request->message,
        ]);

        return response()->json(['message' => "Message sent successfully"], 201);
    }

    public function getMessages($sender_id, $receiver_id)
    {
        $messages = Message::where(function ($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $sender_id)
                ->where('receiver_id', $receiver_id);
        })->orWhere(function ($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $receiver_id)
                ->where('receiver_id', $sender_id);
        })->orderBy('created_at')->get();

        return response()->json(['messages' => $messages], 200);
    }
}
