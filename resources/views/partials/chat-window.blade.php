<div id="chatWindow" class="col-md-9 d-flex flex-column justify-content-between p-0"
     style="height: 90vh; font-size: 14px;">
    <!-- Chat Navbar -->
   @include('partials.chat-navbar')
    <div id="messagesLoader" class="text-center py-2 d-none">
        <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
        <span class="small text-muted ms-2">Loading more messages...</span>
    </div>
    {{-- Chat Message --}}
    <div id="messages" data-conversation-id="{{ $conversation['conversation']['id'] }}" class="flex-grow-1 p-3" style="overflow-y: auto; background-color: #f1f1f1;">
        @foreach($conversation['messages'] as $message)
            @include('partials.message', ['message' => $message])
        @endforeach
    </div>
    <!-- Send Message Form -->
     @include('partials.chat-form')
</div>
