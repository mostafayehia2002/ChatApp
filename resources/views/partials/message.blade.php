<div class="mb-3 d-flex {{ $message['is_me'] ? 'justify-content-end' : 'justify-content-start' }}"
     data-message-id="{{ $message['id'] }}">

    @php
        $bgColor = $message['is_me'] ? 'linear-gradient(135deg, #667eea, #764ba2)' : '#ffffff';
        $textColor = $message['is_me'] ? '#ffffff' : '#1f2937';
        $borderColor = $message['is_me'] ? 'transparent' : '#e5e7eb';
        $hasMedia = !empty($message['media']);
        $padding = $hasMedia ? '6px' : '12px 16px';
    @endphp

    <div class="message-bubble"
         style="max-width: 70%; background: {{ $bgColor }}; color: {{ $textColor }}; border: 1px solid {{ $borderColor }}; padding: {{ $padding }}; border-radius: 16px; word-wrap: break-word; animation: slideInUp 0.3s ease-out;">

        <!-- Text Content -->
        @if(!empty($message['body']))
            <div style="{{ $hasMedia ? 'margin-bottom: 8px; padding: 0 8px; margin-top: 4px;' : '' }} line-height: 1.4;">
                {{ $message['body'] }}
            </div>
        @endif

        <!-- Media Content -->
        @if($hasMedia)
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 8px; margin-top: {{ !empty($message['body']) ? '8px' : '0' }};">
                @foreach($message['media'] as $media)
                    <div style="position: relative; width: 100%; border-radius: 12px; overflow: hidden; background: #000; aspect-ratio: 1;">

                        @if($media['media_category'] === 'image')
                            <a href="{{ $media['file_url'] }}" target="_blank" style="display: block; width: 100%; height: 100%;">
                                <img src="{{ $media['file_url'] }}" alt="{{ $media['file_name'] }}"
                                     style="width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 12px; transition: all 0.3s;"
                                     onmouseover="this.style.transform='scale(1.05)';"
                                     onmouseout="this.style.transform='scale(1)';">
                            </a>

                        @elseif($media['media_category'] === 'video')
                            <video controls preload="metadata" playsinline
                                   style="width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 12px; background: #000;">
                                <source src="{{ $media['file_url'] }}">
                            </video>

                        @else
                            <div style="height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; background: #f9fafb; border-radius: 12px; padding: 12px;">
                                <div style="font-size: 32px; margin-bottom: 8px;">
                                    @php
                                        $extension = strtoupper(pathinfo($media['file_name'], PATHINFO_EXTENSION));
                                    @endphp
                                    📄
                                </div>
                                <div style="font-size: 12px; font-weight: 600; color: #1f2937; word-break: break-word; margin-bottom: 4px;">
                                    {{ substr($media['file_name'], 0, 20) }}...
                                </div>
                                <div style="font-size: 11px; color: #9ca3af;">
                                    {{ $media['human_file_size'] }}
                                </div>
                            </div>
                        @endif

                        <!-- File Info Overlay -->
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 8px; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent); color: #fff; font-size: 11px; display: flex; justify-content: space-between; align-items: flex-end;">
                            <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 130px; font-weight: 500;">
                                {{ $media['file_name'] }}
                            </span>

                            <a href="{{ $media['file_url'] }}" download
                               style="color: #fff; text-decoration: none; font-size: 14px; transition: all 0.3s; cursor: pointer;"
                               onmouseover="this.style.transform='scale(1.2)';"
                               onmouseout="this.style.transform='scale(1)';">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Message Meta (Time & Read Status) -->
        @if($message['is_me'])
            <div style="margin-top: 6px; display: flex; justify-content: flex-end; align-items: center; gap: 6px; font-size: 11px; color: rgba(255,255,255,0.8);">
                <span>{{ $message['time'] }}</span>
                @if($message['is_read'])
                    <i class="fas fa-check-double" style="color: #53bdeb;"></i>
                @else
                    <i class="fas fa-check-double" style="color: rgba(255,255,255,0.6);"></i>
                @endif
            </div>
        @else
            <div style="margin-top: 6px; font-size: 11px; color: #9ca3af; font-weight: 500;">
                {{ $message['time'] }}
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

