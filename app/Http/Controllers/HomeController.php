<?php

namespace App\Http\Controllers;

use App\Services\ConversationService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    protected ConversationService $conversationService;
    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }
    public function index(){

        return view('index');
    }
}
