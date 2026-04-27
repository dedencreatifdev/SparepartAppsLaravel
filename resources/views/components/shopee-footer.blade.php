<!-- Bottom Navigation -->
<div class="bottom-nav">
    <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <i data-lucide="home"></i>
        <span class="nav-label">Beranda</span>
    </a>
    <a href="#" class="nav-item">
        <i data-lucide="play-square"></i>
        <span class="nav-label">Live</span>
    </a>
    <a href="#" class="nav-item">
        <i data-lucide="clapperboard"></i>
        <span class="nav-label">Video</span>
    </a>
    <a href="#" class="nav-item">
        <div class="badge-container">
            <i data-lucide="bell"></i>
            <span class="badge" style="top: -5px; right: -5px; font-size: 8px;">76</span>
        </div>
        <span class="nav-label">Notifikasi</span>
    </a>
    <a href="{{ route('profile') }}" wire:navigate class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
        <i data-lucide="user"></i>
        <span class="nav-label">Saya</span>
    </a>
</div>
