<div id="chatWindow" class="d-flex flex-column justify-content-between p-0 w-100" style="height: 93vh; font-size: 14px; background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);">
    <!-- Chat Navbar -->
    @include('partials.chat-navbar')

    <!-- Messages Loader -->
    <div id="messagesLoader" class="text-center py-3 d-none" style="background: #f0f4f8; border-bottom: 1px solid #e5e7eb;">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="color: #667eea;"></span>
        <span class="small ms-2" style="color: #9ca3af;">Loading more messages...</span>
    </div>

    <!-- Chat Messages -->
    <div id="messages" data-conversation-id="{{ $conversation['conversation']['id'] }}"
         class="flex-grow-1 p-4"
         style="overflow-y: auto; min-height: 0;">
        @foreach ($conversation['messages'] as $message)
            @include('partials.message', ['message' => $message])
        @endforeach
    </div>

    <!-- Send Message Form -->
    @include('partials.chat-form')
</div>
