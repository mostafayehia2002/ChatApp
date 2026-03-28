<?php

namespace App\Http\Controllers;

use App\Services\ConversationService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        return view('index');
    }
}
