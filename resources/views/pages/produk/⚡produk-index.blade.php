<?php

use App\Models\Product;
use Livewire\Component;

new class extends Component {
    public $perPage = 6;
    public $search = '';
    public $sort = 'terkait';

    public function updatedSearch()
    {
        $this->perPage = 6;
    }

    public function updatedSort()
    {
        $this->perPage = 6;
    }

    public function loadMore()
    {
        $this->perPage += 6;
    }

    public function with(): array
    {
        $query = Product::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%');
            });
        }

        switch ($this->sort) {
            case 'terbaru':
                $query->latest();
                break;
            case 'terlaris':
                $query->orderByDesc('sales_count');
                break;
            case 'harga_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'harga_desc':
                $query->orderByDesc('price');
                break;
            case 'sku_asc':
                $query->orderBy('sku', 'asc');
                break;
            case 'sku_desc':
                $query->orderBy('sku', 'desc');
                break;
            case 'terkait':
            default:
                // Default sorting
                // $query->latest();
                $query->orderBy('sku', 'asc');
                break;
        }

        $totalProducts = clone $query;
        return [
            'products' => $query->take($this->perPage)->get(),
            'hasMore' => $totalProducts->count() > $this->perPage,
        ];
    }
};
?>
@push('styles')
    @vite(['resources/css/shopee.css'])
    <style>
        .product-nav {
            background: white !important;
            border-bottom: 1px solid #f0f0f0;
            color: #ee4d2d;
        }

        .product-nav .search-container {
            background: #f5f5f5;
            border-radius: 4px;
        }

        .product-nav .search-bar {
            background: transparent;
            color: #333;
            border: none;
        }

        .product-nav .search-bar::placeholder {
            color: #bbb;
        }

        .filter-tabs {
            display: flex;
            background: white;
            border-bottom: 1px solid #f0f0f0;
            position: sticky;
            top: 56px;
            z-index: 40;
        }

        .filter-tab {
            flex: 1;
            text-align: center;
            padding: 12px 5px;
            font-size: 13px;
            color: #555;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-tab.active {
            color: #ee4d2d;
            border-bottom: 2px solid #ee4d2d;
            font-weight: 500;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

<div class="shopee-container" style="background: #f5f5f5;">
    <!-- Top Navigation -->
    <nav class="top-nav product-nav">
        <a href="{{ route('home') }}" wire:navigate style="color: #ee4d2d; display: flex; align-items: center;">
            <i data-lucide="arrow-left"></i>
        </a>
        <div class="search-container">
            <i data-lucide="search" style="width: 16px; height: 16px; color: #999; margin-left: 10px;"></i>
            <input type="text" class="search-bar" wire:model.live.debounce.300ms="search" placeholder="Cari Produk atau SKU" style="padding-left: 15px;">
        </div>
        <div class="nav-icons" style="color: #ee4d2d;">
            <div class="badge-container">
                <i data-lucide="shopping-cart"></i>
                <span class="badge" style="background: #ee4d2d; color: white; border-color: white;">4</span>
            </div>
            <i data-lucide="message-circle"></i>
        </div>
    </nav>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <div class="filter-tab {{ $sort === 'terkait' ? 'active' : '' }}" wire:click="$set('sort', 'terkait')">Terkait</div>
        <div class="filter-tab {{ $sort === 'terbaru' ? 'active' : '' }}" wire:click="$set('sort', 'terbaru')">Terbaru</div>
        <div class="filter-tab {{ $sort === 'terlaris' ? 'active' : '' }}" wire:click="$set('sort', 'terlaris')">Terlaris</div>
        <div class="filter-tab {{ in_array($sort, ['harga_asc', 'harga_desc']) ? 'active' : '' }}" wire:click="$set('sort', '{{ $sort === 'harga_asc' ? 'harga_desc' : 'harga_asc' }}')" style="display: flex; align-items: center; justify-content: center; gap: 4px;">
            Harga
            @if($sort === 'harga_asc')
                <i data-lucide="arrow-up" style="width: 12px; height: 12px;"></i>
            @elseif($sort === 'harga_desc')
                <i data-lucide="arrow-down" style="width: 12px; height: 12px;"></i>
            @else
                <i data-lucide="chevrons-up-down" style="width: 12px; height: 12px;"></i>
            @endif
        </div>
        <div class="filter-tab {{ in_array($sort, ['sku_asc', 'sku_desc']) ? 'active' : '' }}" wire:click="$set('sort', '{{ $sort === 'sku_asc' ? 'sku_desc' : 'sku_asc' }}')" style="display: flex; align-items: center; justify-content: center; gap: 4px;">
            SKU
            @if($sort === 'sku_asc')
                <i data-lucide="arrow-up" style="width: 12px; height: 12px;"></i>
            @elseif($sort === 'sku_desc')
                <i data-lucide="arrow-down" style="width: 12px; height: 12px;"></i>
            @else
                <i data-lucide="chevrons-up-down" style="width: 12px; height: 12px;"></i>
            @endif
        </div>
    </div>

    <!-- Product Grid -->
    <div class="product-grid" style="margin-bottom: 10px;">
        @foreach ($products as $product)
            <div class="product-card">
                <div class="product-image-container">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}">
                    @if ($product->discount_percent > 0)
                        <div class="product-badge-overlay">-{{ $product->discount_percent }}%</div>
                    @endif
                    @if ($product->is_promo_xtra)
                        <div
                            style="position: absolute; bottom: 0; left: 0; background: #fff000; color: #ee4d2d; font-size: 10px; font-weight: 900; padding: 2px 4px; display: flex; flex-direction: column; line-height: 1;">
                            <span>PROMO</span>
                            <span>XTRA</span>
                        </div>
                    @endif
                </div>
                <div class="product-details">
                    <div class="product-title">
                        @if ($product->is_star_plus)
                            <span class="star-badge">Star+</span>
                        @endif
                        {{ $product->name }}
                    </div>
                    <div style="font-size: 10px; color: #888; margin-top: 2px; margin-bottom: 6px;">
                        SKU: {{ $product->sku }}
                    </div>
                    @if ($product->discount_amount > 0)
                        <div class="product-promo-tag" style="background: #ee4d2d; color: white;">
                            <i data-lucide="percent" style="width: 10px; height: 10px; margin-right: 2px;"></i> Diskon
                            Rp{{ number_format($product->discount_amount, 0, ',', '.') }}
                        </div>
                    @endif
                    <div class="product-price-row">
                        <span class="product-price-currency">Rp</span>
                        <span class="product-price">{{ number_format($product->price, 0, ',', '.') }}</span>
                        <i data-lucide="ticket" style="width: 14px; height: 14px; color: #ee4d2d; margin-left: 4px;"></i>
                    </div>
                    <div class="product-stats">
                        <i data-lucide="star" style="width: 10px; height: 10px; color: #ffc107; fill: #ffc107;"></i>
                        {{ $product->rating }} <span style="color: #ccc; margin: 0 4px;">|</span>
                        {{ $product->sales_count >= 1000 ? number_format($product->sales_count / 1000, 1) . 'RB+' : $product->sales_count }}
                        terjual
                    </div>
                    <div class="product-location">
                        <div style="display: flex; align-items: center; gap: 4px; color: #00bfa5;">
                            <i data-lucide="truck" style="width: 12px; height: 12px;"></i> {{ $product->shipping_time }}
                        </div>
                        <div style="display: flex; align-items: center; gap: 4px; color: #999;">
                            <i data-lucide="map-pin" style="width: 10px; height: 10px;"></i>
                            {{ \Illuminate\Support\Str::limit($product->location, 15) }}
                        </div>
                        <i data-lucide="more-horizontal" style="width: 14px; height: 14px; color: #999;"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Infinite Scroll Sentinel -->
    @if ($hasMore)
        <div x-intersect="$wire.loadMore()" style="text-align: center; padding: 20px 0 40px; color: #ee4d2d;">
            <div wire:loading>
                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                    <i data-lucide="loader-2" class="animate-spin" style="width: 24px; height: 24px;"></i>
                    <span style="font-size: 12px; font-weight: 500;">Memuat lebih banyak...</span>
                </div>
            </div>
            <div wire:loading.remove>
                <span style="font-size: 12px; color: #888;">Scroll untuk melihat lebih banyak</span>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 20px 0 40px; color: #888; font-size: 12px;">
            Sudah mencapai akhir daftar produk
        </div>
    @endif

    <!-- Bottom Navigation -->
    <x-shopee-footer />
</div>
