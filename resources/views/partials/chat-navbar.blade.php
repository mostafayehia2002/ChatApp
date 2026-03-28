<div class="bg-white p-2 px-3 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
        <img src="{{$conversation['chat_user']['image']}}" alt="Ahmed Mohamed" class="rounded-circle"
             style="width: 40px; height: 40px;">
        <div>
            <strong>{{$conversation['chat_user']['name']}}</strong><br>
            <small class="text-muted">{{$conversation['chat_user']['last_seen']}} </small>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
