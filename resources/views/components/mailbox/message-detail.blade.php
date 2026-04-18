{{-- Mobile back button --}}
<div class="md:hidden flex items-center px-4 py-3 border-b border-gray-200">
    <button onclick="idtzBackToList()" class="flex items-center gap-1.5 text-indigo-600 text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Inbox
    </button>
</div>

{{-- Empty state --}}
<div id="idtz-empty-state" class="flex-1 flex flex-col items-center justify-center text-gray-400">
    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
    </svg>
    <p class="text-sm font-medium text-gray-500">Pilih pesan untuk dibaca</p>
    <p class="text-xs text-gray-400 mt-1">Pesan akan tampil di sini</p>
</div>

{{-- Chat Content --}}
<div id="idtz-detail-content" class="hidden flex-1 flex flex-col overflow-hidden">

    {{-- Chat Header --}}
    <div class="flex items-center gap-3 px-5 py-3 border-b border-gray-200 bg-white">
        <div id="idtz-chat-avatar" class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold flex-shrink-0"></div>
        <div class="flex-1 min-w-0">
            <p id="idtz-chat-name" class="text-sm font-semibold text-gray-900 truncate"></p>
            <p id="idtz-chat-subtitle" class="text-xs text-gray-400 truncate"></p>
        </div>
        <button onclick="idtzDeleteActive()" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    </div>

    {{-- Bubble List --}}
    <div id="idtz-chat-bubbles" class="flex-1 overflow-y-auto px-4 py-4 space-y-1 bg-gray-50"></div>

    {{-- Reply Input (inbox only) --}}
    <div id="idtz-reply-box" class="px-4 py-3 border-t border-gray-200 bg-white">
        <div class="flex items-end gap-2">
            <div class="flex-1 border border-gray-200 rounded-2xl overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition bg-gray-50">
                <textarea
                    id="idtz-reply-input"
                    placeholder="Tulis balasan..."
                    rows="1"
                    oninput="this.style.height='auto';this.style.height=Math.min(this.scrollHeight,120)+'px'"
                    class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 resize-none focus:outline-none bg-transparent"
                ></textarea>
            </div>
            <button
                id="idtz-reply-btn"
                onclick="idtzSendReply()"
                class="w-9 h-9 flex-shrink-0 flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white rounded-full transition-colors"
            >
                <svg class="w-4 h-4 translate-x-px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </div>
    </div>

</div>

<script>
    function idtzToggleMeta(el) {
        const meta     = el.nextElementSibling;
        const isHidden = meta.classList.contains('hidden');
        document.querySelectorAll('.idtz-meta').forEach(m => m.classList.add('hidden'));
        if (isHidden) meta.classList.remove('hidden');
    }
</script>
