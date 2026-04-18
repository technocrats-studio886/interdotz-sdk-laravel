<div id="idtz-compose-modal" class="hidden fixed inset-0 z-50 flex items-end justify-end p-6">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/20" onclick="idtzCloseCompose()"></div>

    {{-- Modal --}}
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden" style="height: 520px">

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 bg-gray-900 text-white">
            <h3 class="text-sm font-medium">Pesan Baru</h3>
            <button onclick="idtzCloseCompose()" class="p-1 rounded hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Fields --}}
        <div class="flex flex-col border-b border-gray-200">
            <div class="flex items-center px-4 py-2.5 border-b border-gray-100">
                <span class="text-xs text-gray-400 w-24 flex-shrink-0">User ID Penerima</span>
                <input
                    id="idtz-compose-recipient-id"
                    type="text"
                    placeholder="ID pengguna penerima"
                    class="flex-1 text-sm text-gray-800 placeholder-gray-400 focus:outline-none ml-2"
                />
            </div>
            <div class="flex items-center px-4 py-2.5 border-b border-gray-100">
                <span class="text-xs text-gray-400 w-24 flex-shrink-0">Client ID</span>
                <input
                    id="idtz-compose-recipient-client"
                    type="text"
                    placeholder="Client ID penerima"
                    class="flex-1 text-sm text-gray-800 placeholder-gray-400 focus:outline-none ml-2"
                />
            </div>
            <div class="flex items-center px-4 py-2.5">
                <span class="text-xs text-gray-400 w-24 flex-shrink-0">Subjek</span>
                <input
                    id="idtz-compose-subject"
                    type="text"
                    placeholder="Subjek pesan"
                    class="flex-1 text-sm text-gray-800 placeholder-gray-400 focus:outline-none ml-2"
                />
            </div>
        </div>

        {{-- Body --}}
        <textarea
            id="idtz-compose-body"
            placeholder="Tulis pesan kamu di sini..."
            class="flex-1 px-4 py-3 text-sm text-gray-800 placeholder-gray-400 resize-none focus:outline-none"
        ></textarea>

        {{-- Footer --}}
        <div class="flex items-center justify-between px-4 py-3 border-t border-gray-100">
            <div></div>
            <div class="flex items-center gap-2">
                <button onclick="idtzCloseCompose()" class="text-xs text-gray-500 hover:text-gray-700 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <button
                    id="idtz-send-btn"
                    onclick="idtzSendMail()"
                    class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition-colors"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim
                </button>
            </div>
        </div>

    </div>
</div>
