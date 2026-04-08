<!-- Media Preview Container -->
<div id="previewContainer" style="display: flex; flex-wrap: wrap; gap: 12px; background: #f9fafb; border-top: 1px solid #e5e7eb; min-height: auto;"></div>

<!-- Message Form -->
<form id="messageForm" method="POST" action="{{ route('chat.store') }}" enctype="multipart/form-data"
    style="display: flex; border-top: 1px solid #e5e7eb; padding: 14px 16px; background: white; gap: 10px; align-items: flex-end; position: relative;">
    @csrf
    <input type="hidden" name="conversation_id" value="{{ $conversation['conversation']['id'] }}">

    <!-- Message Input -->
    <textarea id="messageInput"
              name="body"
              class="form-control"
              placeholder="Type your message... "
              autocomplete="off"
              rows="1"
              style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px 16px; font-size: 14px; flex: 1; transition: all 0.3s; resize: none; max-height: 120px; min-height: 44px; font-family: 'Inter', sans-serif;"
              onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
              onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"></textarea>

    <!-- Attach File Button -->
    <label for="fileInput"
           class="btn"
           title="Attach Files"
           style="cursor: pointer; padding: 12px 14px; background: white; border: 2px solid #e5e7eb; border-radius: 10px; color: #667eea; font-size: 16px; transition: all 0.3s; display: flex; align-items: center; justify-content: center; margin: 0; flex-shrink: 0;"
           onmouseover="this.style.backgroundColor='#f3f4f6'; this.style.borderColor='#667eea'; this.style.transform='scale(1.1)';"
           onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#e5e7eb'; this.style.transform='scale(1)';">
        <i class="fas fa-paperclip"></i>
    </label>
    <input type="file" id="fileInput" name="attachment[]" style="display: none;" multiple accept="image/*,video/*,.pdf,.doc,.docx,.txt" />

    <!-- Send Button -->
    <button type="submit"
            id="sendBtn"
            class="btn"
            style="padding: 12px 20px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 6px; flex-shrink: 0; min-width: 50px; white-space: nowrap;"
            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(102, 126, 234, 0.3)';"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
        <i class="fas fa-paper-plane"></i>
    </button>
</form>

@push('script')
    <script>
        const messageInput = document.getElementById('messageInput');
        const messageForm = document.getElementById('messageForm');
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');
        const sendBtn = document.getElementById('sendBtn');

        // Auto-resize textarea
        if (messageInput) {
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });

            // Send with Alt+Enter
            messageInput.addEventListener('keydown', function(e) {
                if (e.altKey && e.key === 'Enter') {
                    e.preventDefault();
                    messageForm.submit();
                }
            });
        }

        // Handle file uploads
        if (fileInput && previewContainer) {
            fileInput.addEventListener('change', function() {
                previewContainer.innerHTML = '';

                if (this.files.length === 0) return;

                const countDiv = document.createElement('div');
                countDiv.style.width = '100%';
                countDiv.style.fontSize = '12px';
                countDiv.style.color = '#6b7280';
                countDiv.innerHTML = `📎 ${this.files.length} file(s)`;
                previewContainer.appendChild(countDiv);

                Array.from(this.files).forEach((file, index) => {
                    const fileURL = URL.createObjectURL(file);
                    let element;
                    let wrapper = document.createElement('div');

                    wrapper.style.position = 'relative';
                    wrapper.style.borderRadius = '10px';
                    wrapper.style.overflow = 'hidden';
                    wrapper.style.width = '100px';
                    wrapper.style.height = '100px';
                    wrapper.style.background = '#e5e7eb';

                    if (file.type.startsWith('image/')) {
                        element = document.createElement('img');
                        element.src = fileURL;
                        element.style.width = '100%';
                        element.style.height = '100%';
                        element.style.objectFit = 'cover';
                    } else if (file.type.startsWith('video/')) {
                        element = document.createElement('video');
                        element.src = fileURL;
                        element.style.width = '100%';
                        element.style.height = '100%';
                        element.style.objectFit = 'cover';
                        element.style.background = '#000';
                    } else {
                        element = document.createElement('div');
                        const ext = file.name.split('.').pop().toUpperCase();
                        element.innerHTML = `${ext}`;
                        element.style.display = 'flex';
                        element.style.alignItems = 'center';
                        element.style.justifyContent = 'center';
                        element.style.width = '100%';
                        element.style.height = '100%';
                        element.style.background = '#f3f4f6';
                        element.style.fontSize = '12px';
                        element.style.fontWeight = '600';
                        element.style.color = '#667eea';
                    }

                    element.style.borderRadius = '10px';

                    let removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerHTML = '✕';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '-6px';
                    removeBtn.style.right = '-6px';
                    removeBtn.style.width = '24px';
                    removeBtn.style.height = '24px';
                    removeBtn.style.background = '#ef4444';
                    removeBtn.style.border = 'none';
                    removeBtn.style.borderRadius = '50%';
                    removeBtn.style.cursor = 'pointer';
                    removeBtn.style.color = 'white';
                    removeBtn.style.transition = 'all 0.3s';

                    removeBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        wrapper.remove();
                        const dt = new DataTransfer();
                        Array.from(fileInput.files).forEach((f, i) => {
                            if (i !== index) dt.items.add(f);
                        });
                        fileInput.files = dt.files;
                        fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                    });

                    wrapper.appendChild(element);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                });
            });
        }
    </script>
@endpush
