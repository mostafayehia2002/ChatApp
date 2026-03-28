<div id="previewContainer" class="p-2 d-flex flex-wrap gap-2"></div>
<form id="messageForm" method="POST" action="{{route('chat.store')}}" enctype="multipart/form-data"
      class="d-flex border-top p-2 px-3 bg-white">
    @csrf
    <input type="hidden" name="conversation_id" value="{{$conversation['conversation']['id']}}">
    <input id="messageInput" name="body" class="form-control me-2 form-control-sm"
           placeholder="Type your message..." autocomplete="off">
    <label for="fileInput" class="btn btn-light me-2 mb-0" title="Attach File" style="cursor: pointer;">
        <i class="fas fa-paperclip"></i>
    </label>
    <input type="file" id="fileInput" name="attachment[]" class="d-none"  multiple/>
    <button type="submit" class="btn btn-primary btn-sm">Send</button>
</form>
@push('script')
    {{--  Review media before sending it  --}}
    <script>
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');

        if (fileInput && previewContainer) {
            fileInput.addEventListener('change', function () {
                previewContainer.innerHTML = '';

                Array.from(this.files).forEach(file => {
                    const fileURL = URL.createObjectURL(file);
                    let element;

                    if (file.type.startsWith('image/')) {
                        element = document.createElement('img');
                        element.src = fileURL;
                    } else if (file.type.startsWith('video/')) {
                        element = document.createElement('video');
                        element.src = fileURL;
                        element.controls = true;
                    } else {
                        element = document.createElement('div');
                        element.innerHTML = `📄 ${file.name}`;
                        element.style.display = 'flex';
                        element.style.alignItems = 'center';
                        element.style.justifyContent = 'center';
                        element.style.background = '#eee';
                        element.style.padding = '10px';
                    }

                    element.style.width = '100px';
                    element.style.height = '100px';
                    element.style.objectFit = 'cover';
                    element.style.borderRadius = '8px';

                    previewContainer.appendChild(element);
                });
            });
        }
    </script>

@endpush
