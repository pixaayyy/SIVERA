<style>
    .notification-wrapper {
        position: relative;
    }
    .notification-icon {
        font-size: 20px;
        color: #888;
        cursor: pointer;
        position: relative;
        padding: 5px;
    }
    .notification-icon.has-unread::after {
        content: '';
        position: absolute;
        top: 2px;
        right: 2px;
        width: 8px;
        height: 8px;
        background: red;
        border-radius: 50%;
    }
    .notification-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        width: 300px;
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-radius: 8px;
        margin-top: 10px;
        z-index: 1000;
        border: 1px solid #eee;
    }
    .notification-dropdown.show {
        display: block;
    }
    .notification-header {
        padding: 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .notification-header h4 {
        margin: 0;
        font-size: 14px;
        color: #333;
    }
    .mark-all-read {
        font-size: 12px;
        color: #38b6ff;
        cursor: pointer;
        text-decoration: none;
    }
    .notification-list {
        max-height: 300px;
        overflow-y: auto;
    }
    .notification-item {
        padding: 12px 15px;
        border-bottom: 1px solid #f9f9f9;
        display: block;
        text-decoration: none;
        color: #555;
    }
    .notification-item:hover {
        background: #f4f7f6;
    }
    .notification-item.unread {
        background: #e6f5ff;
    }
    .notification-title {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 4px;
        color: #333;
    }
    .notification-desc {
        font-size: 12px;
        margin-bottom: 5px;
    }
    .notification-time {
        font-size: 10px;
        color: #aaa;
    }
</style>

@php
    $unreadNotifications = auth()->user()->unreadNotifications;
@endphp

<div class="notification-wrapper">
    <div class="notification-icon {{ $unreadNotifications->count() > 0 ? 'has-unread' : '' }}" onclick="toggleNotif()">
        <i class="fa-regular fa-bell"></i>
    </div>

    <div class="notification-dropdown" id="notifDropdown">
        <div class="notification-header">
            <h4>Notifikasi ({{ $unreadNotifications->count() }})</h4>
            @if($unreadNotifications->count() > 0)
                <a href="{{ route('notifikasi.readAll') }}" class="mark-all-read">Tandai dibaca</a>
            @endif
        </div>
        <div class="notification-list">
            @forelse($unreadNotifications as $notif)
                <a href="{{ route('notifikasi.read', $notif->id) }}" class="notification-item unread">
                    <div class="notification-title">{{ $notif->data['title'] ?? 'Pemberitahuan' }}</div>
                    <div class="notification-desc">{{ $notif->data['message'] ?? '' }}</div>
                    <div class="notification-time">{{ $notif->created_at->diffForHumans() }}</div>
                </a>
            @empty
                <div class="notification-item" style="text-align: center; color: #888;">
                    Tidak ada notifikasi baru
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function toggleNotif() {
        document.getElementById('notifDropdown').classList.toggle('show');
    }
    
    window.onclick = function(event) {
        if (!event.target.closest('.notification-wrapper')) {
            var dropdowns = document.getElementsByClassName("notification-dropdown");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>