@extends('layouts.app')
@if(request()->routeIs('home'))
    @section('content')
        {{-- if no chat selected --}}
        <div id="noChatPlaceholder" class="col-md-9 d-flex flex-column justify-content-center align-items-center p-0"
             style="height: 90vh; font-size: 14px; background-color: #f8f9fa;">

            <i class="fas fa-comments text-secondary mb-3" style="font-size: 48px;"></i>

            <p class="text-muted text-center" style="font-size: 16px;">
                No chat selected. Please select a contact to start chatting.
            </p>
        </div>
    @endsection
@elseif(request()->routeIs('chat/*'))
    @section('content')
        <!-- Chat Window -->
        <div id="chatWindow" class="col-md-9 d-flex flex-column justify-content-between p-0"
             style="height: 90vh; font-size: 14px;">
            <!-- Chat Navbar -->
            <div class="bg-white p-2 px-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <img src="https://i.pravatar.cc/40?img=1" alt="Ahmed Mohamed" class="rounded-circle"
                         style="width: 40px; height: 40px;">
                    <div>
                        <strong>Ahmed Mohamed</strong><br>
                        <small class="text-muted">Online </small>
                    </div>
                </div>

                <div>
                    <!-- Search Button with same bg as settings -->
                    <button class="btn btn-sm btn-light me-2" data-bs-toggle="modal" data-bs-target="#searchChatModal"
                            title="Search Chat">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatSettingsModal"
                            title="Settings">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>

            <!-- Messages or default placeholder -->
            <div id="messages" class="flex-grow-1 p-3" style="overflow-y: auto; background-color: #f1f1f1;">


                <!-- Example messages -->
                <div class="mb-2 d-flex justify-content-end">
                    <div class="p-2 px-3 rounded bg-primary text-white" style="max-width: 75%;">
                        Hey Ahmed! How are you? first
                        <div class="text-white-50 small text-end">10:30 AM</div>
                    </div>
                </div>
                <div class="mb-2 d-flex justify-content-start">
                    <div class="p-2 px-3 rounded bg-white border" style="max-width: 75%;">
                        I'm good, thanks! What about you?
                        <div class="text-muted small">10:31 AM</div>
                    </div>
                </div>
                <!-- Example messages -->
                <div class="mb-2 d-flex justify-content-end">
                    <div class="p-2 px-3 rounded bg-primary text-white" style="max-width: 75%;">
                        Hey Ahmed! How are you?
                        <div class="text-white-50 small text-end">10:30 AM</div>
                    </div>
                </div>
                <div class="mb-2 d-flex justify-content-start">
                    <div class="p-2 px-3 rounded bg-white border" style="max-width: 75%;">
                        I'm good, thanks! What about you?
                        <div class="text-muted small">10:31 AM</div>
                    </div>
                </div>
                <!-- Example messages -->
                <div class="mb-2 d-flex justify-content-end">
                    <div class="p-2 px-3 rounded bg-primary text-white" style="max-width: 75%;">
                        Hey Ahmed! How are you?
                        <div class="text-white-50 small text-end">10:30 AM</div>
                    </div>
                </div>
                <div class="mb-2 d-flex justify-content-start">
                    <div class="p-2 px-3 rounded bg-white border" style="max-width: 75%;">
                        I'm good, thanks! What about you?
                        <div class="text-muted small">10:31 AM</div>
                    </div>
                </div>
                <!-- Example messages -->
                <div class="mb-2 d-flex justify-content-end">
                    <div class="p-2 px-3 rounded bg-primary text-white" style="max-width: 75%;">
                        Hey Ahmed! How are you?
                        <div class="text-white-50 small text-end">10:30 AM</div>
                    </div>
                </div>
                <div class="mb-2 d-flex justify-content-start">
                    <div class="p-2 px-3 rounded bg-white border" style="max-width: 75%;">
                        I'm good, thanks! What about you?
                        <div class="text-muted small">10:31 AM</div>
                    </div>
                </div>
                <!-- Example messages -->
                <div class="mb-2 d-flex justify-content-end">
                    <div class="p-2 px-3 rounded bg-primary text-white" style="max-width: 75%;">
                        Hey Ahmed! How are you?
                        <div class="text-white-50 small text-end">10:30 AM</div>
                    </div>
                </div>
                <div class="mb-2 d-flex justify-content-start">
                    <div class="p-2 px-3 rounded bg-white border" style="max-width: 75%;">
                        I'm good, thanks! What about you? last
                        <div class="text-muted small">10:31 AM</div>
                    </div>
                </div>
            </div>
            <button id="scrollToBottomBtn" style="position: fixed; bottom: 90px; right: 30px; z-index: 1000;"
                    class="btn btn-sm btn-warning">
                <i class="fa-solid fa-down-long"></i>
            </button>
            <!-- Send Message Form -->
            <form id="messageForm" method="POST" action="#" enctype="multipart/form-data"
                  class="d-flex border-top p-2 px-3 bg-white">
                <input id="messageInput" name="body" class="form-control me-2 form-control-sm"
                       placeholder="Type your message..." autocomplete="off" required>
                <label for="fileInput" class="btn btn-light me-2 mb-0" title="Attach File" style="cursor: pointer;">
                    <i class="fas fa-paperclip"></i>
                </label>
                <input type="file" id="fileInput" name="attachment" class="d-none" />
                <button type="submit" class="btn btn-primary btn-sm">Send</button>
            </form>
        </div>

        <!-- Chat Settings Modal -->
        <div class="modal fade" id="chatSettingsModal" tabindex="-1" aria-labelledby="chatSettingsModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chatSettingsModalLabel">Chat Settings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Settings options go here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search Chat Modal -->
        <div class="modal fade" id="searchChatModal" tabindex="-1" aria-labelledby="searchChatModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchChatModalLabel">Search Chat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" placeholder="Type to search messages...">
                        <!-- هنا ممكن تضيف نتائج البحث ديناميك -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endif
