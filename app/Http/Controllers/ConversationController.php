<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationRequest;
use App\Services\ConversationService;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    protected ConversationService $conversationService;
    public function __construct(ConversationService $conversationService){

        $this->conversationService = $conversationService;
    }
    public function store(StoreConversationRequest $request)
    {
        $response=$this->conversationService->store($request);
        if($response['success']){
            notifyMessage(message:$response['message']);
            return redirect()->back();
        }
        notifyMessage(message:$response['message'], type:'error');
        return redirect()->back()->withInput($request->only( 'email','message'));
    }

    public function showConversation($conversationId, Request $request)
    {
        $conversationData = $this->conversationService->showConversation(
            $conversationId,
            auth()->id(),
            $request->last_message_id
        );

        return view('index', ['conversation' => $conversationData]);
    }

    /**
     * @throws \Throwable
     */
    public function getMoreMessages($conversationId, Request $request)
    {
        $messagesData = $this->conversationService->getMoreMessages(
            $conversationId,
            auth()->id(),
            $request->query('last_message_id')
        );

        $html = '';
        foreach ($messagesData['formatted'] as $message) {
            $html .= view('partials.message', ['message' => $message])->render();
        }

        return response()->json([
            'html' => $html,
            'count' => count($messagesData['formatted']),
        ]);
    }
}
