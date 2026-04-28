<?php

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component
{
    public function with(): array
    {
        return [
            'products' => Product::latest()->take(10)->get(),
            'products_promo' => Product::latest()->take(5)->get(),
        ];
    }
};
?>

@push('styles')
    @vite(['resources/css/shopee.css'])
@endpush

<div class="shopee-container">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="search-container">
            <i data-lucide="search" class="search-icon text-white" style="width: 16px; height: 16px; color: white;"></i>
            <input type="text" class="search-bar text-white" placeholder="Case iPhone Murah">
            <i data-lucide="camera" class="camera-icon text-white" style="width: 18px; height: 18px; color: white;"></i>
        </div>
        <div class="nav-icons">
            <div class="badge-container">
                <i data-lucide="shopping-cart" style="width: 22px; height: 22px; text-white"></i>
                <span class="badge">4</span>
            </div>
            <div class="badge-container">
                <i data-lucide="message-circle" style="width: 22px; height: 22px;"></i>
                <span class="badge">7</span>
            </div>
        </div>
    </nav>

    <!-- Hero Banner -->
    <div class="hero-section">
        <div class="hero-slider" id="heroSlider">
            <div class="hero-slide">
                <img src="/shopee_hero_banner_1777264848107.png" alt="Hero Banner 1" class="hero-image">
            </div>
            <div class="hero-slide">
                <img src="/shopee_promo_banners_1777264868246.png" alt="Hero Banner 2" class="hero-image">
            </div>
            <div class="hero-slide">
                <img src="/shopee_hero_banner_1777264848107.png" alt="Hero Banner 3" class="hero-image">
            </div>
        </div>
        <div class="slider-indicators" id="sliderIndicators">
            <span class="indicator active"></span>
            <span class="indicator"></span>
            <span class="indicator"></span>
        </div>
    </div>

    <!-- Wallet Section -->
    <div class="wallet-section">
        <div class="wallet-card">
            <div class="wallet-item">
                <div style="display: flex; align-items: center; gap: 4px;">
                    <i data-lucide="wallet" style="width: 14px; height: 14px; color: #ee4d2d;"></i>
                    <span class="wallet-label">Rp0.00</span>
                </div>
                <span class="wallet-subtext">Isi Saldo</span>
            </div>
            <div class="wallet-item">
                <div style="display: flex; align-items: center; gap: 4px;">
                    <i data-lucide="coins" style="width: 14px; height: 14px; color: #fbc02d;"></i>
                    <span class="wallet-label">25</span>
                </div>
                <span class="wallet-subtext">Koin Saya</span>
            </div>
            <div class="wallet-item">
                <i data-lucide="send" class="wallet-icon"></i>
                <span class="wallet-label">Transfer</span>
                <span class="wallet-subtext">Gratis</span>
            </div>
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="menu-grid">
        <div class="menu-item">
            <div class="menu-icon-box" style="color: #ff9800; background: #fff3e0;"><i data-lucide="ticket"></i></div>
            <span class="menu-text">Estimasi</span>
        </div>
        <div class="menu-item">
            <div class="menu-icon-box" style="color: #00bcd4; background: #e0f7fa;"><i data-lucide="smartphone"></i></div>
            <span class="menu-text">Katalog</span>
        </div>
        <div class="menu-item">
            <div class="menu-icon-box" style="color: #f44336; background: #ffebee;"><i data-lucide="shopping-bag"></i></div>
            <span class="menu-text">Booking</span>
        </div>
        <div class="menu-item">
            <div class="menu-icon-box" style="color: #ff5722; background: #fbe9e7;"><i data-lucide="car"></i></div>
            <span class="menu-text">Kendaraan</span>
        </div>
        <div class="menu-item">
            <div class="menu-icon-box" style="color: #4caf50; background: #e8f5e9;"><i data-lucide="moon"></i></div>
            <span class="menu-text">Shopee Barokah</span>
        </div>
        <div class="menu-item">
            <div class="menu-icon-box" style="color: #2196f3; background: #e3f2fd;"><i data-lucide="gift"></i></div>
            <span class="menu-text">Hadiah Shopee</span>
        </div>
        <div class="menu-item">
            <div class="menu-icon-box" style="color: #ff5722; background: #fff5f2;"><i data-lucide="utensils-crossed"></i></div>
            <span class="menu-text">ShopeeFood</span>
        </div>
        <div class="menu-item">
            <div class="menu-icon-box" style="color: #3f51b5; background: #e8eaf6;"><i data-lucide="map-pin"></i></div>
            <span class="menu-text">Shopee Pilih Lokal</span>
        </div>
        <div class="menu-item">
            <div class="menu-icon-box" style="color: #ee4d2d; background: #fff5f2;"><i data-lucide="credit-card"></i></div>
            <span class="menu-text">SPayLater</span>
        </div>
        <div class="menu-item">
            <div class="menu-icon-box" style="color: #ff5722; background: #fff5f2;"><i data-lucide="grid"></i></div>
            <span class="menu-text">Lihat Semua</span>
        </div>
    </div>

    <!-- Promo Banners -->
    <div class="promo-banners">
        <div class="promo-card">
            <img src="/shopee_promo_banners_1777264868246.png" alt="Promo 1">
        </div>
        <div class="promo-card">
            <img src="/shopee_promo_banners_1777264868246.png" alt="Promo 2" style="object-position: center;">
        </div>
    </div>

    <!-- Flash Sale Section -->
    <div class="flash-sale-container" style="background: white; padding-bottom: 20px;">
        <div class="flash-sale-header">
            <div class="flash-sale-title">
                <div class="flash-sale-logo">
                    <i data-lucide="zap" style="width: 20px; height: 20px; fill: #ee4d2d;"></i>
                    <span>FLASH SALE</span>
                </div>
                <div class="timer-box">
                    <span class="time-unit">01</span>
                    <span style="font-weight: bold; color: #ee4d2d;">:</span>
                    <span class="time-unit">25</span>
                    <span style="font-weight: bold; color: #ee4d2d;">:</span>
                    <span class="time-unit">48</span>
                </div>
            </div>
            <div class="see-all">
                Lihat Semua <i data-lucide="chevron-right" style="width: 14px; height: 14px;"></i>
            </div>
        </div>

        <div class="flash-sale-products">
            @foreach ($products_promo as $product)
            <div class="fs-product-card">
                <div class="fs-product-image">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}">
                    <div class="fs-discount-tag">{{ $product->discount }}%</div>
                </div>
                <div class="fs-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="fs-stock-bar">
                    <div class="fs-stock-fill"></div>
                    <span class="fs-stock-text">Segera Habis</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Product List Section -->
    <div class="recommended-products-header">
        <div class="recommended-products-title">
            <span>Rekomendasi</span>
        </div>
        <div class="recommended-products-actions">
            <a wire:navigate href="{{ route('produk') }}"><span>Lihat Semua</span>
            </a>
            <i data-lucide="chevron-right" style="width: 14px; height: 14px;"></i>
        </div>
    </div>

    <div class="product-grid" style="margin-bottom: 20px;">
        @foreach($products as $product)
        <div class="product-card">
            <div class="product-image-container">
                <img src="{{ $product->image }}" alt="{{ $product->name }}">
                @if($product->discount_percent > 0)
                <div class="product-badge-overlay">-{{ $product->discount_percent }}%</div>
                @endif
                @if($product->is_promo_xtra)
                <div style="position: absolute; bottom: 0; left: 0; background: #fff000; color: #ee4d2d; font-size: 10px; font-weight: 900; padding: 2px 4px; display: flex; flex-direction: column; line-height: 1;">
                    <span>PROMO</span>
                    <span>XTRA</span>
                </div>
                @endif
            </div>
            <div class="product-details">
                <div class="product-title">
                    @if($product->is_star_plus)
                    <span class="star-badge">Star+</span>
                    @endif
                    {{ $product->name }}
                </div>
                @if($product->discount_amount > 0)
                <div class="product-promo-tag" style="background: #ee4d2d; color: white;">
                    <i data-lucide="percent" style="width: 10px; height: 10px; margin-right: 2px;"></i> Diskon Rp{{ number_format($product->discount_amount, 0, ',', '.') }}
                </div>
                @endif
                <div class="product-price-row">
                    <span class="product-price-currency">Rp</span>
                    <span class="product-price">{{ number_format($product->price, 0, ',', '.') }}</span>
                    <i data-lucide="ticket" style="width: 14px; height: 14px; color: #ee4d2d; margin-left: 4px;"></i>
                </div>
                <div class="product-stats">
                    <i data-lucide="star" style="width: 10px; height: 10px; color: #ffc107; fill: #ffc107;"></i> {{ $product->rating }} <span style="color: #ccc; margin: 0 4px;">|</span> {{ $product->sales_count >= 1000 ? number_format($product->sales_count/1000, 1) . 'RB+' : $product->sales_count }} terjual
                </div>
                <div class="product-location">
                    <div style="display: flex; align-items: center; gap: 4px; color: #00bfa5;">
                        <i data-lucide="truck" style="width: 12px; height: 12px;"></i> {{ $product->shipping_time }}
                    </div>
                    <div style="display: flex; align-items: center; gap: 4px; color: #999;">
                        <i data-lucide="map-pin" style="width: 10px; height: 10px;"></i> {{ \Illuminate\Support\Str::limit($product->location, 15) }}
                    </div>
                    <i data-lucide="more-horizontal" style="width: 14px; height: 14px; color: #999;"></i>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <!-- Bottom Navigation -->
    <x-shopee-footer />

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Simple scroll animation for top nav
        window.addEventListener('scroll', () => {
            const topNav = document.querySelector('.top-nav');
            if (window.scrollY > 50) {
                topNav.style.background = '#ee4d2d';
            } else {
                topNav.style.background = 'linear-gradient(to right, #ff5722, #ff4400)';
            }
        });

        // Hero Slider Logic
        document.addEventListener('DOMContentLoaded', () => {
            const slider = document.getElementById('heroSlider');
            const indicators = document.querySelectorAll('.indicator');
            let currentSlide = 0;
            const totalSlides = indicators.length;

            setInterval(() => {
                currentSlide = (currentSlide + 1) % totalSlides;
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;

                indicators.forEach((ind, index) => {
                    if (index === currentSlide) {
                        ind.classList.add('active');
                    } else {
                        ind.classList.remove('active');
                    }
                });
            }, 3000); // 3 seconds
        });
    </script>
</div>
