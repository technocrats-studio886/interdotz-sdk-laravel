<div
    class="idtz-message-item px-4 py-3 cursor-pointer hover:bg-gray-50 transition-colors bg-white"
    data-id="{{ $id }}"
    data-unread="{{ $unread ? 'true' : 'false' }}"
    data-folder="{{ $folder ?? 'all' }}"
    onclick="idtzSelectMessage({{ $id }})"
>
    <div class="flex items-start gap-3">
        {{-- Avatar --}}
        <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold flex-shrink-0">
            {{ $avatar }}
        </div>

        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-0.5">
                <span class="text-sm {{ $unread ? 'font-semibold text-gray-900' : 'font-medium text-gray-700' }} truncate">
                    {{ $name }}
                </span>
                <span class="text-xs text-gray-400 flex-shrink-0 ml-2">{{ $time }}</span>
            </div>
            <div class="text-xs {{ $unread ? 'font-medium text-gray-800' : 'text-gray-600' }} truncate mb-0.5">
                {{ $subject }}
            </div>
            <div class="text-xs text-gray-400 truncate">{{ $preview }}</div>
        </div>

        {{-- Unread dot --}}
        @if ($unread)
            <div class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0 mt-1.5"></div>
        @endif
    </div>
</div>
