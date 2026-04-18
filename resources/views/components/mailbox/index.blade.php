@props(['accessToken', 'height' => 'h-screen'])

<div class="flex {{ $height }} bg-white font-sans text-sm text-gray-800 overflow-hidden relative">

    {{-- Mobile Nav Overlay --}}
    <div id="idtz-nav-overlay" class="hidden fixed inset-0 z-30 bg-black/30 md:hidden" onclick="idtzCloseNav()"></div>

    {{-- Nav Sidebar --}}
    <div id="idtz-nav-sidebar"
        class="fixed md:static z-40 top-0 left-0 h-full -translate-x-full md:translate-x-0 transition-transform duration-200
               w-56 bg-gray-50 border-r border-gray-200 flex flex-col flex-shrink-0"
    >
        <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200">
            <span class="text-base font-semibold text-gray-900">Mailbox</span>
            <button onclick="idtzCloseNav()" class="md:hidden p-1 rounded hover:bg-gray-200 text-gray-500 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="px-3 py-3">
            <button
                onclick="idtzOpenCompose()"
                class="w-full flex items-center justify-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium px-3 py-2 rounded-lg transition-colors"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Compose
            </button>
        </div>

        <nav class="flex-1 px-3 space-y-0.5">
            @foreach ([
                'all'    => ['label' => 'All Messages', 'icon' => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4'],
                'unread' => ['label' => 'Unread',       'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
                'sent'   => ['label' => 'Sent',         'icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8'],
            ] as $key => $item)
                <button
                    onclick="idtzSetFilter('{{ $key }}')"
                    data-filter="{{ $key }}"
                    class="idtz-nav-item w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors
                        {{ $key === 'all' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900' }}"
                >
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                    <span class="flex-1 text-left">{{ $item['label'] }}</span>
                    @if ($key === 'unread')
                        <span id="idtz-unread-badge" class="hidden bg-indigo-600 text-white text-[10px] font-semibold px-1.5 py-0.5 rounded-full"></span>
                    @endif
                </button>
            @endforeach
        </nav>
    </div>

    {{-- Message List --}}
    <div id="idtz-sidebar" class="w-full md:w-80 flex-shrink-0 border-r border-gray-200 flex flex-col">

        <div class="flex items-center gap-3 px-4 py-4 border-b border-gray-200">
            <button onclick="idtzOpenNav()" class="md:hidden p-1.5 rounded-lg hover:bg-gray-100 text-gray-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <h1 id="idtz-list-title" class="text-base font-semibold text-gray-900 flex-1">All Messages</h1>
            <button id="idtz-mark-all-btn" onclick="idtzMarkAllRead()" class="hidden text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                Tandai semua dibaca
            </button>
        </div>

        <div class="px-4 py-3 border-b border-gray-200">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input
                    type="text"
                    placeholder="Search messages..."
                    oninput="idtzSearch(this.value)"
                    class="w-full pl-9 pr-3 py-2 bg-gray-100 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                />
            </div>
        </div>

        <div id="idtz-message-list" class="flex-1 overflow-y-auto divide-y divide-gray-100">
            <div class="flex items-center justify-center h-24 text-gray-400 text-xs">
                <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                Memuat...
            </div>
        </div>
    </div>

    {{-- Detail Panel --}}
    <div id="idtz-detail-panel" class="hidden md:flex flex-1 flex-col">
        @include('interdotz::components.mailbox.message-detail')
    </div>

</div>

{{-- Compose Modal --}}
@include('interdotz::components.mailbox.compose-modal')

<script>
(function () {
    const IDTZ_TOKEN = @json($accessToken);
    const IDTZ_CSRF  = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const IDTZ_LABELS = { all: 'All Messages', unread: 'Unread', sent: 'Sent' };

    let idtzFilter      = 'all';
    let idtzActiveId    = null;
    let idtzInbox       = null;
    let idtzSent        = null;
    let idtzSearchQuery = '';

    const isMobile = () => window.innerWidth < 768;

    // ── HTTP helpers ─────────────────────────────────────────────────────────

    async function idtzGet(url, params = {}) {
        const qs  = new URLSearchParams(params).toString();
        const res = await fetch(qs ? `${url}?${qs}` : url, {
            headers: {
                'Authorization': `Bearer ${IDTZ_TOKEN}`,
                'Accept':        'application/json',
            },
        });
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            throw new Error(err.message || 'Request failed');
        }
        return res.json();
    }

    async function idtzPost(url, body = {}) {
        const res = await fetch(url, {
            method:  'POST',
            headers: {
                'Authorization': `Bearer ${IDTZ_TOKEN}`,
                'Accept':        'application/json',
                'Content-Type':  'application/json',
                'X-CSRF-TOKEN':  IDTZ_CSRF,
            },
            body: JSON.stringify(body),
        });
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            throw new Error(err.message || 'Request failed');
        }
        return res.json();
    }

    async function idtzPut(url) {
        const res = await fetch(url, {
            method:  'PUT',
            headers: {
                'Authorization': `Bearer ${IDTZ_TOKEN}`,
                'Accept':        'application/json',
                'X-CSRF-TOKEN':  IDTZ_CSRF,
            },
        });
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            throw new Error(err.message || 'Request failed');
        }
        return res.json();
    }

    async function idtzDelete(url) {
        const res = await fetch(url, {
            method:  'DELETE',
            headers: {
                'Authorization': `Bearer ${IDTZ_TOKEN}`,
                'Accept':        'application/json',
                'X-CSRF-TOKEN':  IDTZ_CSRF,
            },
        });
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            throw new Error(err.message || 'Request failed');
        }
        return res.json();
    }

    // ── Utilities ────────────────────────────────────────────────────────────

    function idtzInitials(name) {
        return (name || '??').split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase();
    }

    function idtzFormatDate(iso) {
        if (!iso) return '';
        const d    = new Date(iso);
        const now  = new Date();
        const diff = now - d;
        const mins = Math.floor(diff / 60000);
        if (mins < 60)     return `${mins || 1}m`;
        if (diff < 86400000 && d.getDate() === now.getDate()) {
            return d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }
        if (diff < 86400000 * 2) return 'Kemarin';
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    }

    function idtzFormatFull(iso) {
        if (!iso) return '';
        return new Date(iso).toLocaleString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric',
            hour: '2-digit', minute: '2-digit',
        });
    }

    // ── Render ────────────────────────────────────────────────────────────────

    function idtzRenderItem(item, type) {
        const isSent   = type === 'sent';
        const id       = isSent ? item.id : item.mailId;
        const name     = isSent ? item.recipientUsername : item.senderUsername;
        const initials = idtzInitials(name);
        const time     = idtzFormatDate(item.createdAt);
        const subject  = item.subject || '(tanpa subjek)';
        const preview  = (item.body || '').slice(0, 80);
        const isUnread = !isSent && !item.isRead;

        return `
        <div class="idtz-message-item px-4 py-3 cursor-pointer hover:bg-gray-50 transition-colors bg-white"
            data-id="${id}" data-type="${type}" data-subject="${subject.replace(/"/g,'&quot;')}"
            data-name="${name}" data-unread="${isUnread}"
            onclick="idtzSelectMessage('${id}', '${type}')">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold flex-shrink-0">
                    ${initials}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-0.5">
                        <span class="text-sm ${isUnread ? 'font-semibold text-gray-900' : 'font-medium text-gray-700'} truncate">
                            ${name}
                        </span>
                        <span class="text-xs text-gray-400 flex-shrink-0 ml-2">${time}</span>
                    </div>
                    <div class="text-xs ${isUnread ? 'font-medium text-gray-800' : 'text-gray-600'} truncate mb-0.5">
                        ${subject}
                    </div>
                    ${preview ? `<div class="text-xs text-gray-400 truncate">${preview}</div>` : ''}
                </div>
                ${isUnread ? '<div class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0 mt-1.5"></div>' : ''}
            </div>
        </div>`;
    }

    function idtzRenderList() {
        const container = document.getElementById('idtz-message-list');
        let items = [];

        if (idtzFilter === 'sent') {
            items = (idtzSent?.items || []).map(i => ({ item: i, type: 'sent' }));
        } else if (idtzFilter === 'unread') {
            items = (idtzInbox?.items || []).filter(i => !i.isRead).map(i => ({ item: i, type: 'inbox' }));
        } else {
            items = (idtzInbox?.items || []).map(i => ({ item: i, type: 'inbox' }));
        }

        if (idtzSearchQuery) {
            const q = idtzSearchQuery.toLowerCase();
            items = items.filter(({ item }) =>
                (item.senderUsername || '').toLowerCase().includes(q) ||
                (item.subject || '').toLowerCase().includes(q) ||
                (item.body || '').toLowerCase().includes(q)
            );
        }

        if (items.length === 0) {
            container.innerHTML = '<div class="flex items-center justify-center h-24 text-xs text-gray-400">Tidak ada pesan</div>';
            return;
        }

        container.innerHTML = items.map(({ item, type }) => idtzRenderItem(item, type)).join('');
    }

    function idtzUpdateBadge(count) {
        const badge = document.getElementById('idtz-unread-badge');
        if (!badge) return;
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    // ── Data loading ─────────────────────────────────────────────────────────

    async function idtzLoadInbox() {
        try {
            idtzInbox = await idtzGet('/interdotz/mailbox/inbox');
            idtzUpdateBadge(idtzInbox.unreadCount ?? 0);

            const markAllBtn = document.getElementById('idtz-mark-all-btn');
            if (markAllBtn) {
                markAllBtn.classList.toggle('hidden', (idtzInbox.unreadCount ?? 0) === 0);
            }
        } catch (e) {
            document.getElementById('idtz-message-list').innerHTML =
                `<div class="flex items-center justify-center h-24 text-xs text-red-400">${e.message}</div>`;
            return;
        }
        idtzRenderList();
    }

    async function idtzLoadSent() {
        if (idtzSent) { idtzRenderList(); return; }
        try {
            idtzSent = await idtzGet('/interdotz/mailbox/sent');
        } catch (e) {
            document.getElementById('idtz-message-list').innerHTML =
                `<div class="flex items-center justify-center h-24 text-xs text-red-400">${e.message}</div>`;
            return;
        }
        idtzRenderList();
    }

    // ── Actions ───────────────────────────────────────────────────────────────

    window.idtzSetFilter = function (filter) {
        idtzFilter = filter;

        document.getElementById('idtz-list-title').textContent = IDTZ_LABELS[filter];

        document.querySelectorAll('.idtz-nav-item').forEach(el => {
            const active = el.dataset.filter === filter;
            el.classList.toggle('bg-indigo-50',        active);
            el.classList.toggle('text-indigo-700',     active);
            el.classList.toggle('text-gray-600',      !active);
            el.classList.toggle('hover:bg-gray-200',  !active);
            el.classList.toggle('hover:text-gray-900',!active);
        });

        const markAllBtn = document.getElementById('idtz-mark-all-btn');
        if (markAllBtn) markAllBtn.classList.toggle('hidden', filter !== 'all' && filter !== 'unread');

        if (filter === 'sent') {
            document.getElementById('idtz-message-list').innerHTML =
                '<div class="flex items-center justify-center h-24 text-gray-400 text-xs"><svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/></svg>Memuat...</div>';
            idtzLoadSent();
        } else {
            idtzRenderList();
        }

        if (isMobile()) idtzCloseNav();
    };

    window.idtzSelectMessage = async function (id, type) {
        idtzActiveId = id;

        document.querySelectorAll('.idtz-message-item').forEach(el => {
            el.classList.toggle('bg-indigo-50',     el.dataset.id === id);
            el.classList.toggle('border-l-2',       el.dataset.id === id);
            el.classList.toggle('border-indigo-600',el.dataset.id === id);
        });

        document.getElementById('idtz-empty-state').classList.add('hidden');
        const detail = document.getElementById('idtz-detail-content');
        detail.classList.remove('hidden');
        detail.classList.add('flex');

        const item = type === 'sent'
            ? idtzSent?.items.find(i => i.id === id)
            : idtzInbox?.items.find(i => i.mailId === id);

        idtzRenderDetail(item, type);

        if (type === 'inbox' && item && !item.isRead) {
            try {
                await idtzPut(`/interdotz/mailbox/${id}/read`);
                item.isRead = true;
                item.readAt = new Date().toISOString();
                if (idtzInbox) {
                    idtzInbox.unreadCount = Math.max(0, (idtzInbox.unreadCount ?? 1) - 1);
                    idtzUpdateBadge(idtzInbox.unreadCount);
                }
                const el = document.querySelector(`.idtz-message-item[data-id="${id}"]`);
                if (el) {
                    el.dataset.unread = 'false';
                    el.querySelector('.bg-indigo-500.rounded-full')?.remove();
                    const nameEl = el.querySelector('.text-sm');
                    if (nameEl) { nameEl.classList.remove('font-semibold'); nameEl.classList.add('font-medium'); }
                }
            } catch (_) { /* non-critical */ }
        }

        if (isMobile()) {
            document.getElementById('idtz-sidebar').classList.add('hidden');
            const panel = document.getElementById('idtz-detail-panel');
            panel.classList.remove('hidden');
            panel.classList.add('flex');
        }
    };

    window.idtzMarkAllRead = async function () {
        try {
            await idtzPut('/interdotz/mailbox/read-all');
            if (idtzInbox) {
                idtzInbox.items.forEach(i => { i.isRead = true; });
                idtzInbox.unreadCount = 0;
                idtzUpdateBadge(0);
            }
            idtzRenderList();
            document.getElementById('idtz-mark-all-btn')?.classList.add('hidden');
        } catch (e) {
            alert(e.message);
        }
    };

    window.idtzDeleteActive = async function () {
        if (!idtzActiveId) return;
        if (!confirm('Hapus pesan ini?')) return;
        try {
            await idtzDelete(`/interdotz/mailbox/${idtzActiveId}`);
            if (idtzInbox) {
                idtzInbox.items = idtzInbox.items.filter(i => i.mailId !== idtzActiveId);
            }
            if (idtzSent) {
                idtzSent.items = idtzSent.items.filter(i => i.id !== idtzActiveId);
            }
            idtzActiveId = null;
            document.getElementById('idtz-empty-state').classList.remove('hidden');
            document.getElementById('idtz-detail-content').classList.add('hidden');
            idtzRenderList();
        } catch (e) {
            alert(e.message);
        }
    };

    // ── Detail render ─────────────────────────────────────────────────────────

    function idtzRenderDetail(item, type) {
        if (!item) return;

        const name     = (type === 'sent' ? item.recipientUsername : item.senderUsername) || '?';
        const initials = idtzInitials(name);
        const subject  = item.subject || '(tanpa subjek)';
        const date     = idtzFormatFull(item.createdAt);

        document.getElementById('idtz-chat-avatar').textContent  = initials;
        document.getElementById('idtz-chat-name').textContent   = name;
        document.getElementById('idtz-chat-subtitle').textContent =
            type === 'sent'
                ? `Kepada · ${item.recipientClientName || ''}`
                : item.senderClientName || '';

        const replyBox = document.getElementById('idtz-reply-box');
        if (replyBox) replyBox.classList.toggle('hidden', type === 'sent');

        const container = document.getElementById('idtz-chat-bubbles');

        if (type === 'sent') {
            container.innerHTML = idtzDateDivider(date) + idtzBubble({
                out:         true,
                text:        item.body || '',
                time:        idtzFormatDate(item.createdAt),
                date:        date,
                from:        item.senderUsername,
                to:          item.recipientUsername || '—',
                status:      'Terkirim',
                statusClass: 'text-blue-600',
            });
        } else {
            const clientInfo = item.senderClientName
                ? `<span class="text-[11px] text-indigo-300 ml-1">${item.senderClientName}</span>`
                : '';
            container.innerHTML = idtzDateDivider(date) + idtzBubble({
                out:         false,
                text:        `<p class="font-semibold mb-1">${subject}</p><p>${item.body || ''}</p>${clientInfo}`,
                time:        idtzFormatDate(item.createdAt),
                date:        date,
                from:        item.senderUsername,
                to:          'Kamu',
                status:      item.isRead ? 'Dibaca' : 'Belum dibaca',
                statusClass: item.isRead ? 'text-green-600' : 'text-yellow-600',
            });
        }

        container.scrollTop = container.scrollHeight;
    }

    function idtzDateDivider(label) {
        return `<div class="flex items-center gap-3 py-2">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-[10px] text-gray-400 font-medium flex-shrink-0">${label}</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>`;
    }

    function idtzBubble({ out, text, time, date, from, to, status, statusClass }) {
        const bubbleColor = out ? 'bg-indigo-600 text-white' : 'bg-white text-gray-800';
        const rounded     = out ? 'rounded-2xl rounded-br-sm' : 'rounded-2xl rounded-bl-sm';
        const timeAlign   = out ? 'text-right mr-1' : 'ml-1';
        const tick        = out ? ' ✓✓' : '';
        const avatar      = out ? '' : `
            <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-[10px] font-semibold flex-shrink-0 mb-5">
                ${idtzInitials(from)}
            </div>`;

        return `
        <div class="idtz-bubble flex items-end ${out ? 'justify-end' : ''} gap-2">
            ${avatar}
            <div class="max-w-[75%]">
                <div class="idtz-bubble-body ${bubbleColor} ${rounded} px-3.5 py-2.5 shadow-sm cursor-pointer select-none" onclick="idtzToggleMeta(this)">
                    ${text}
                </div>
                <div class="idtz-meta hidden mt-1.5 bg-white border border-gray-100 rounded-xl px-3 py-2 shadow-sm text-[11px] text-gray-500 space-y-0.5">
                    <div class="flex gap-2"><span class="font-medium text-gray-400 w-12">Dari</span><span class="text-gray-700">${from}</span></div>
                    <div class="flex gap-2"><span class="font-medium text-gray-400 w-12">Ke</span><span class="text-gray-700">${to}</span></div>
                    <div class="flex gap-2"><span class="font-medium text-gray-400 w-12">Waktu</span><span class="text-gray-700">${date}</span></div>
                    <div class="flex gap-2"><span class="font-medium text-gray-400 w-12">Status</span><span class="${statusClass} font-medium">${status}</span></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1 ${timeAlign}">${time}${tick}</p>
            </div>
        </div>`;
    }

    // ── Nav helpers ───────────────────────────────────────────────────────────

    window.idtzOpenNav  = () => {
        document.getElementById('idtz-nav-sidebar').classList.remove('-translate-x-full');
        document.getElementById('idtz-nav-overlay').classList.remove('hidden');
    };
    window.idtzCloseNav = () => {
        document.getElementById('idtz-nav-sidebar').classList.add('-translate-x-full');
        document.getElementById('idtz-nav-overlay').classList.add('hidden');
    };
    window.idtzBackToList = () => {
        document.getElementById('idtz-sidebar').classList.remove('hidden');
        const panel = document.getElementById('idtz-detail-panel');
        panel.classList.add('hidden');
        panel.classList.remove('flex');
    };
    window.idtzSearch = (val) => {
        idtzSearchQuery = val;
        idtzRenderList();
    };
    window.idtzOpenCompose  = () => {
        document.getElementById('idtz-compose-modal').classList.remove('hidden');
        if (isMobile()) idtzCloseNav();
    };
    window.idtzCloseCompose = () => {
        document.getElementById('idtz-compose-modal').classList.add('hidden');
    };

    // ── Send mail ─────────────────────────────────────────────────────────────

    window.idtzSendMail = async function () {
        const recipientId       = document.getElementById('idtz-compose-recipient-id').value.trim();
        const recipientClientId = document.getElementById('idtz-compose-recipient-client').value.trim();
        const subject           = document.getElementById('idtz-compose-subject').value.trim();
        const body              = document.getElementById('idtz-compose-body').value.trim();
        const btn               = document.getElementById('idtz-send-btn');

        if (!recipientId || !recipientClientId || !subject || !body) {
            alert('Semua field wajib diisi.'); return;
        }

        btn.disabled    = true;
        btn.textContent = 'Mengirim...';

        try {
            await idtzPost('/interdotz/mailbox/send', {
                recipient_id:        recipientId,
                recipient_client_id: recipientClientId,
                subject,
                body,
            });
            idtzSent = null; // invalidate sent cache
            idtzCloseCompose();
            ['idtz-compose-recipient-id','idtz-compose-recipient-client','idtz-compose-subject','idtz-compose-body']
                .forEach(id => { document.getElementById(id).value = ''; });
        } catch (e) {
            alert(e.message);
        } finally {
            btn.disabled    = false;
            btn.textContent = 'Kirim';
        }
    };

    // ── Reply ─────────────────────────────────────────────────────────────────

    window.idtzSendReply = async function () {
        const body = document.getElementById('idtz-reply-input')?.value.trim();
        if (!body) return;

        const item = idtzInbox?.items.find(i => i.mailId === idtzActiveId);
        if (!item) return;

        const btn = document.getElementById('idtz-reply-btn');
        if (btn) btn.disabled = true;

        try {
            await idtzPost('/interdotz/mailbox/send', {
                recipient_id:        item.senderId,
                recipient_client_id: item.senderClientId,
                subject:             `Re: ${item.subject}`,
                body,
            });
            idtzSent = null;
            document.getElementById('idtz-reply-input').value = '';
            document.getElementById('idtz-reply-input').style.height = 'auto';
        } catch (e) {
            alert(e.message);
        } finally {
            if (btn) btn.disabled = false;
        }
    };

    // ── Init ──────────────────────────────────────────────────────────────────

    idtzLoadInbox();
})();
</script>
