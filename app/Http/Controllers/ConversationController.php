<?php

namespace App\Http\Controllers;

use App\Services\ConversationService;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    protected ConversationService $conversationService;
    public function __construct(ConversationService $conversationService){

        $this->conversationService = $conversationService;
    }

    public function showConversation($conversationId, Request $request)
    {

        $response= $this->conversationService->showConversation($conversationId, $request);


       return view('index', ['conversation' => $response]);
    }
}
