<!-- Sidebar: Contacts -->
<div class="col-md-3 border-end p-0" style="height: 90vh; overflow-y: auto; font-size: 14px;">

    <div class="bg-white p-2 px-3 d-flex justify-content-between align-items-center border-bottom">
        <strong class="text-muted">Conversations</strong>

        <button class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center"
                data-bs-toggle="modal"
                data-bs-target="#addContactModal"
                style="width: 34px; height: 34px;">
            <i class="fas fa-user-plus"></i>
        </button>
    </div>

    <!-- search -->
    <div class="px-3 pt-3 pb-2">
        <form class="position-relative" action="{{route('home') }}" method="POST">
            @csrf
            <input type="text"
                   name="search"
                  value="{{ request('search') }}"
                   class="form-control form-control-sm rounded-pill ps-4 pe-5"
                   placeholder=""
                   id="contactsSearchInput">

            <!-- search icon -->
            <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

            <!-- button -->
            <button type="submit"
                    class="btn btn-sm btn-primary position-absolute top-50 end-0 translate-middle-y me-1 rounded-circle"
                    style="width: 30px; height: 30px;">
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
    <!-- Example contacts -->
    <div id="conversions">
        @forelse($conversations as $conversation)
        <a href="{{route('conversation.show',['id'=>$conversation['id']])}}" class="text-decoration-none text-dark" data-id="1">
            <div class="p-2 px-3 border-bottom d-flex align-items-center">
                <!-- avatar -->
                <img src="{{asset($conversation['image'])}}"
                     class="rounded-circle me-2"
                     style="width: 40px; height: 40px; object-fit: cover;" alt="">
                <!-- name + last message -->
                <div class="flex-grow-1 overflow-hidden">
                    <div class="fw-bold text-truncate">
                        {{ $conversation['name'] }}
                    </div>

                    <div class="text-muted small text-truncate">
                        {{ $conversation['last_message'] }}
                    </div>
                </div>

                <!-- right side -->
                <div class="text-end ms-2 d-flex flex-column align-items-end">

                    <!-- time -->
                    <span class="text-muted small">{{ $conversation['time'] }} </span>

                    <!-- unread count -->
                    @if($conversation['unread'] > 0)
                        <span class="badge bg-success mt-1">
                        {{ $conversation['unread'] }}
                    </span>
                    @endif

                </div>
            </div>
        </a>

        @empty

            <div class="text-center text-muted p-3">
                No conversations yet
            </div>

        @endforelse
    </div>
</div>

<!-- New Conversation Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContactModalLabel">New Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addContactForm" action="{{route('chat.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="contactEmail" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="contactEmail" placeholder="Enter email"
                               name="email">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message here</label>
                        <input type="text" class="form-control" id="message" placeholder="Say Hello"
                               name="message" value="Say Hello">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        const searchInput = document.getElementById('contactsSearchInput');

        let timeout = null;
        searchInput.addEventListener('keyup', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const query = this.value;
                window.location.href = `?search=${query}`;
            }, 1000);
        });
    </script>
@endpush
