<!-- Sidebar: Contacts -->
<div id="sidebar" class="border-end p-0 sidebar-container" style="height: 90vh; overflow-y: auto; font-size: 14px; background: #ffffff;">

    <!-- Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
        <div style="color: white; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-comments" style="font-size: 18px;"></i>
            Conversations
        </div>

        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addContactModal"
                style="width: 36px; height: 36px; padding: 0; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: none; transition: all 0.3s;"
                onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.transform='scale(1.05)';"
                onmouseout="this.style.backgroundColor='white'; this.style.transform='scale(1)';">
            <i class="fas fa-plus" style="color: #667eea; font-size: 18px;"></i>
        </button>
    </div>

    <!-- Search -->
    <div style="padding: 16px 16px; background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
        <div style="position: relative; display: flex; align-items: center;">
            <i class="fas fa-search" style="position: absolute; left: 12px; color: #9ca3af; font-size: 14px;"></i>
            <input type="text" id="contactsSearchInput" value="{{ request('search') }}"
                class="form-control" placeholder="Search conversations..."
                style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 12px 10px 36px; font-size: 14px; background: white; transition: all 0.3s;"
                onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
        </div>
    </div>

    <!-- Conversations List -->
    <div id="conversions" style="padding: 8px 0;">
        @forelse($conversations as $conversation)
            <a href="{{ route('conversation.show', ['conversationId' => $conversation['id']]) }}"
                class="text-decoration-none" data-id="1" style="display: block; transition: all 0.3s;">
                <div style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: all 0.3s; background: transparent;"
                     onmouseover="this.style.backgroundColor='#f9fafb';"
                     onmouseout="this.style.backgroundColor='transparent';">

                    <!-- Avatar with Status Indicator -->
                    <div style="position: relative; flex-shrink: 0;">
                        <img src="{{ $conversation['image'] }}" class="rounded-circle"
                            style="width: 48px; height: 48px; object-fit: cover; border: 2px solid #667eea; box-shadow: 0 2px 6px rgba(102, 126, 234, 0.15);" alt="">
                        <div style="position: absolute; bottom: 0; right: 0; width: 12px; height: 12px; background: #10b981; border-radius: 50%; border: 2px solid white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"></div>
                    </div>

                    <!-- Name + Last Message -->
                    <div style="flex-grow: 1; min-width: 0;">
                        <div style="font-weight: 600; color: #1f2937; font-size: 14px; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $conversation['name'] }}
                        </div>

                        <div style="color: #9ca3af; font-size: 13px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $conversation['last_message'] }}
                        </div>
                    </div>

                    <!-- Time + Unread Badge -->
                    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0;">
                        <span style="color: #9ca3af; font-size: 12px; white-space: nowrap;">{{ $conversation['time'] }}</span>

                        @if ($conversation['unread'] > 0)
                            <span style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; min-width: 22px; text-align: center;">
                                {{ $conversation['unread'] }}
                            </span>
                        @else
                            <div style="width: 22px; height: 22px;"></div>
                        @endif
                    </div>
                </div>
            </a>

        @empty

            <div style="text-align: center; color: #9ca3af; padding: 40px 30px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                <i class="fas fa-inbox" style="font-size: 40px; margin-bottom: 12px; color: #d1d5db;"></i>
                <p style="font-size: 14px; margin: 0;">No conversations yet</p>
                <p style="font-size: 12px; color: #d1d5db; margin-top: 6px;">Start a new conversation to begin</p>
            </div>
        @endforelse
    </div>
</div>

<!-- New Conversation Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: 1px solid #e5e7eb; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
            <div style="padding: 24px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h5 style="margin: 0; font-size: 18px; font-weight: 700; color: #1f2937;">
                        <i class="fas fa-comment-medical me-2" style="color: #667eea;"></i>New Conversation
                    </h5>
                    <p style="margin: 4px 0 0 0; font-size: 13px; color: #9ca3af;">Start chatting with someone</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div style="padding: 24px;">
                <form id="addContactForm" action="{{ route('conversation.store') }}" method="POST">
                    @csrf

                    <div style="margin-bottom: 18px;">
                        <label for="contactEmail" style="display: block; font-weight: 600; color: #1f2937; font-size: 14px; margin-bottom: 8px;">
                            <i class="fas fa-envelope me-2" style="color: #667eea;"></i>Email Address
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="contactEmail" placeholder="person@example.com" name="email"
                            style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px 16px; font-size: 14px;">
                        @error('email')
                            <div style="color: #ef4444; font-size: 13px; margin-top: 6px; display: flex; align-items: center; gap: 6px;">
                                <i class="fas fa-exclamation-circle"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label for="message" style="display: block; font-weight: 600; color: #1f2937; font-size: 14px; margin-bottom: 8px;">
                            <i class="fas fa-comment me-2" style="color: #667eea;"></i>Message
                        </label>
                        <input type="text" class="form-control" id="message" placeholder="Say Hello" name="message"
                            value="Say Hello"
                            style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px 16px; font-size: 14px;">
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <button type="button" class="btn" data-bs-dismiss="modal"
                                style="flex: 1; padding: 12px; border: 2px solid #e5e7eb; background: white; color: #6b7280; font-weight: 600; border-radius: 10px; cursor: pointer; transition: all 0.3s;"
                                onmouseover="this.style.backgroundColor='#f9fafb';"
                                onmouseout="this.style.backgroundColor='white';">
                            Cancel
                        </button>
                        <button type="submit" style="flex: 1; padding: 12px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; font-weight: 600; border-radius: 10px; cursor: pointer; transition: all 0.3s;"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 25px rgba(102, 126, 234, 0.4)';"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        const searchInput = document.getElementById('contactsSearchInput');
        if (searchInput) {
            let timeout = null;
            searchInput.addEventListener('keyup', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    const query = this.value;
                    window.location.href = `?search=${encodeURIComponent(query)}`;
                }, 500);
            });
        }
    </script>
@endpush
