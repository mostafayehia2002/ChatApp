@extends('layouts.app')
@section('content')
@if(request()->routeIs('home'))
        {{-- if no chat selected --}}
        @include('partials.chat-placeholder')

@elseif(request()->routeIs('conversation.show'))
        <!-- Chat Window -->
        @include('partials.chat-window', ['conversation' => $conversation])
@endif
@endsection

