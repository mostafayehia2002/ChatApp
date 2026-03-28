<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatRequest;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected ChatService $chatService;
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function store(StoreChatRequest $request)
    {
        $response = $this->chatService->store($request);

        if ($response['success']) {
            notifyMessage(message: $response['message']);
            return redirect()->back();
        }
        notifyMessage(message: $response['message'], type: 'error');
        return redirect()->back();
    }



}
