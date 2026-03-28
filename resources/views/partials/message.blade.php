<div class="mb-2 d-flex {{ $message['is_me'] ? 'justify-content-end' : 'justify-content-start' }}"
     data-message-id="{{ $message['id'] }}">
    @php
        $bgColor = $message['is_me'] ? '#0d6efd' : '#ffffff';
        $textColor = $message['is_me'] ? '#ffffff' : '#000000';
        $hasMedia = !empty($message['media']);
        $borderStyle = $hasMedia ? 'none' : "1px solid " . ($message['is_me'] ? '#0d6efd' : '#cccccc');
        $padding = $hasMedia ? '6px' : '8px 16px';
    @endphp

    <div class="rounded"
         style="max-width: 75%; background-color: {{ $bgColor }}; color: {{ $textColor }}; border: {{ $borderStyle }}; padding: {{ $padding }};">
        @if(!empty($message['body']))
            <div class="{{ $hasMedia ? 'mb-2 px-2 pt-1' : '' }}">{{ $message['body'] }}</div>
        @endif

        @if($hasMedia)
            <div class="d-flex flex-wrap gap-2 mt-2">
                @foreach($message['media'] as $media)
                    <div style="position: relative; width: 180px; border-radius: 10px; overflow: hidden;">
                        @if($media['media_category'] === 'image')
                            <a href="{{ $media['file_url'] }}" target="_blank">
                                <img src="{{ $media['file_url'] }}" alt="{{ $media['file_name'] }}"
                                     style="width: 100%; height: 180px; object-fit: cover; display: block; border-radius: 10px;">
                            </a>
                        @elseif($media['media_category'] === 'video')
                            <video controls preload="metadata" playsinline
                                   style="width: 100%; height: 180px; object-fit: cover; display: block; border-radius: 10px; background: #000;">
                                <source src="{{ $media['file_url'] }}">
                            </video>
                        @else
                            <div class="p-3"
                                 style="height: 180px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; background: #fff; border-radius: 10px;">
                                <div style="font-size: 30px;">📄</div>
                                <div style="font-size: 12px; margin-top: 8px; word-break: break-word; color: #000;">
                                    {{ $media['file_name'] }}
                                </div>
                                <div style="font-size: 11px; margin-top: 4px; color: #666;">
                                    {{ $media['human_file_size'] }}
                                </div>
                            </div>
                        @endif

                        <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 6px 8px; background: rgba(0,0,0,0.45); color: #fff; font-size: 11px; display: flex; justify-content: space-between; align-items: center;">
                            <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 120px;">
                                {{ $media['file_name'] }}
                            </span>

                            <a href="{{ $media['file_url'] }}" download
                               style="color: #fff; text-decoration: none; font-size: 12px;">
                                ⬇
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

            @if($message['is_me'])
                <div class="mt-1 d-flex justify-content-end align-items-center gap-1"
                     style="font-size: 12px; color: rgba(255,255,255,0.85);">
                    <span>{{ $message['time'] }}</span>

                    @if($message['is_read'])
                        <i class="fas fa-check-double" style="color: #53bdeb;"></i>
                    @else
                        <i class="fas fa-check-double" style="color: #ffffff;"></i>
                    @endif
                </div>
            @else
                <div class="mt-1 text-muted small">
                    {{ $message['time'] }}
                </div>
            @endif
    </div>
</div>

