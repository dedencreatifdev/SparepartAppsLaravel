<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

new #[Layout('layouts.app')] class extends Component {
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }
};
?>
@push('styles')
    @vite(['resources/css/shopee.css'])
@endpush
<div class="shopee-container"
    style="max-width: 450px; margin: 0 auto; background: #f5f5f5; min-height: 100vh; position: relative; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; overflow-x: hidden;">
    <!-- Top Red Banner -->
    <div class="profile-header"
        style="background: linear-gradient(to bottom, #ff5722, #ee4d2d); padding: 15px 15px 60px 15px; color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <div style="font-weight: 600; font-size: 18px;">My Profile</div>
            <div style="display: flex; gap: 15px;">
                <i data-lucide="settings" style="width: 24px; height: 24px; color: white; cursor: pointer;"></i>
                <i data-lucide="shopping-cart" style="width: 24px; height: 24px; color: white; cursor: pointer;"></i>
                <i data-lucide="message-square" style="width: 24px; height: 24px; color: white; cursor: pointer;"></i>
            </div>
        </div>

        <div style="display: flex; align-items: flex-start; justify-content: space-between;">
            <!-- User Info -->
            <div style="display: flex; align-items: center; gap: 15px;">
                <div
                    style="width: 65px; height: 65px; border-radius: 50%; background: #ffd0cc; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 2px solid white;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&background=ffd0cc&color=ee4d2d&size=100"
                        alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div>
                    <div style="font-weight: bold; font-size: 18px; margin-bottom: 6px; letter-spacing: 0.5px;">
                        {{ $user->name ?? 'Username' }}</div>
                    <div
                        style="display: inline-flex; align-items: center; background: #ffc107; color: white; font-size: 10px; font-weight: bold; padding: 2px 8px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        GOLD MEMBER <i data-lucide="chevron-right"
                            style="width: 12px; height: 12px; margin-left: 2px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 25px;">
            <div style="display: flex; gap: 25px;">
                <div style="text-align: center;">
                    <div style="font-weight: bold; font-size: 16px;">841</div>
                    <div style="font-size: 11px; opacity: 0.9; margin-top: 2px;">Followers</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-weight: bold; font-size: 16px;">95</div>
                    <div style="font-size: 11px; opacity: 0.9; margin-top: 2px;">Following</div>
                </div>
            </div>
            <div
                style="border: 1px solid rgba(255,255,255,0.7); border-radius: 20px; padding: 6px 12px; font-size: 12px; display: flex; align-items: center; gap: 5px; font-weight: 500; cursor: pointer; transition: background 0.2s;">
                {{ $user->name ?? 'User' }}'s shop <i data-lucide="chevron-right"
                    style="width: 14px; height: 14px;"></i>
            </div>
        </div>
    </div>

    <!-- Setting Card -->
    <div
        style="background: white; border-radius: 12px; margin: -50px 15px 15px 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: relative; z-index: 10;">
        <div
            style="padding: 15px; border-bottom: 1px solid #f5f5f5; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 600; font-size: 14px; color: #333;">Setting</div>
            <div style="font-size: 12px; color: #757575; display: flex; align-items: center; cursor: pointer;">
                View All <i data-lucide="chevron-right" style="width: 14px; height: 14px; margin-left: 2px;"></i>
            </div>
        </div>

        <div
            style="display: flex; justify-content: space-between; padding: 5px 10px; border-bottom: 1px solid #f5f5f5;">


            {{--  --}}
            <div class="menu-grid">
                <div class="menu-item">
                    <div class="menu-icon-box" style="color: #ff9800; background: #fff3e0;"><i data-lucide="ticket"></i>
                    </div>
                    <span class="menu-text">Gratis Ongkir dan Voucher</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon-box" style="color: #00bcd4; background: #e0f7fa;"><i
                            data-lucide="smartphone"></i></div>
                    <span class="menu-text">Pulsa, Tagihan, dan Tiket</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon-box" style="color: #f44336; background: #ffebee;"><i
                            data-lucide="shopping-bag"></i></div>
                    <span class="menu-text">Shopee Mall</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon-box" style="color: #ff5722; background: #fbe9e7;"><i data-lucide="zap"></i>
                    </div>
                    <span class="menu-text">ShopeePay Sekitarmu</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon-box" style="color: #4caf50; background: #e8f5e9;"><i data-lucide="moon"></i>
                    </div>
                    <span class="menu-text">Shopee Barokah</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon-box" style="color: #2196f3; background: #e3f2fd;"><i data-lucide="gift"></i>
                    </div>
                    <span class="menu-text">Hadiah Shopee</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon-box" style="color: #ff5722; background: #fff5f2;"><i
                            data-lucide="utensils-crossed"></i></div>
                    <span class="menu-text">ShopeeFood</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon-box" style="color: #3f51b5; background: #e8eaf6;"><i
                            data-lucide="map-pin"></i></div>
                    <span class="menu-text">Shopee Pilih Lokal</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon-box" style="color: #ee4d2d; background: #fff5f2;"><i
                            data-lucide="credit-card"></i></div>
                    <span class="menu-text">SPayLater</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon-box" style="color: #ff5722; background: #fff5f2;"><i data-lucide="grid"></i>
                    </div>
                    <span class="menu-text">Lihat Semua</span>
                </div>
            </div>
        </div>

        <div
            style="padding: 15px; border-bottom: 1px solid #f5f5f5; display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i data-lucide="smartphone" style="width: 18px; height: 18px; color: #757575;"></i>
                <span style="font-size: 13px; color: #333; font-weight: 500;">Digital Purchases</span>
            </div>
            <i data-lucide="chevron-right" style="width: 16px; height: 16px; color: #9e9e9e;"></i>
        </div>

        <div
            style="padding: 15px; display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i data-lucide="utensils-crossed" style="width: 18px; height: 18px; color: #ee4d2d;"></i>
                <span style="font-size: 13px; color: #333; font-weight: 500;">ShopeeFood Purchase</span>
            </div>
            <i data-lucide="chevron-right" style="width: 16px; height: 16px; color: #9e9e9e;"></i>
        </div>
    </div>

    <!-- Produk Card -->
    <div
        style="background: white; border-radius: 12px; margin: 0 15px 15px 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div style="padding: 15px; border-bottom: 1px solid #f5f5f5;">
            <div style="font-weight: 600; font-size: 14px; color: #333;">Produk</div>
        </div>

        <div
            style="display: grid; grid-template-columns: repeat(5, 1fr); padding: 20px 0; border-bottom: 1px solid #f5f5f5;">
            <div
                style="display: flex; flex-direction: column; align-items: center; text-align: center; cursor: pointer;">
                <i data-lucide="boxes" style="width: 24px; height: 24px; color: #ee4d2d; margin-bottom: 8px;"></i>
                <span style="font-size: 11px; color: #333; margin-bottom: 4px;">Produk List</span>
            </div>
            <div
                style="display: flex; flex-direction: column; align-items: center; text-align: center; cursor: pointer;">
                <i data-lucide="coins" style="width: 24px; height: 24px; color: #fbc02d; margin-bottom: 8px;"></i>
                <span style="font-size: 11px; color: #333; margin-bottom: 4px;">Satuan</span>
            </div>
            <div
                style="display: flex; flex-direction: column; align-items: center; text-align: center; cursor: pointer;">
                <i data-lucide="tag" style="width: 24px; height: 24px; color: #ee4d2d; margin-bottom: 8px;"></i>
                <span style="font-size: 11px; color: #333; margin-bottom: 4px;">Kategori</span>
            </div>
            <div
                style="display: flex; flex-direction: column; align-items: center; text-align: center; cursor: pointer;">
                <i data-lucide="package-open"
                    style="width: 24px; height: 24px; color: #ee4d2d; margin-bottom: 8px;"></i>
                <span style="font-size: 11px; color: #333; margin-bottom: 4px;">Brand</span>
            </div>
            <div
                style="display: flex; flex-direction: column; align-items: center; text-align: center; cursor: pointer;">
                <i data-lucide="gift" style="width: 24px; height: 24px; color: #ee4d2d; margin-bottom: 8px;"></i>
                <span style="font-size: 11px; color: #333; margin-bottom: 4px;">Promo List</span>
            </div>
        </div>

        <a href="{{ route('produk') }}" wire:navigate>
            <div
                style="padding: 15px; display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <svg width="24" height="24" viewBox="0 0 100 100" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="50" fill="#ee4d2d" />
                        <path d="M25 50 C40 30, 60 70, 75 50" stroke="white" stroke-width="8"
                            stroke-linecap="round" />
                    </svg>
                    <span style="font-size: 13px; color: #333; font-weight: 500;">Daftar Produk</span>
                </div>
                <div style="display: flex; align-items: center; gap: 6px;">
                    <span style="font-size: 12px; color: #ee4d2d;">Lihat Semua</span>
                    <i data-lucide="chevron-right" style="width: 16px; height: 16px; color: #9e9e9e;"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Laporan Card -->
    <div
        style="background: white; border-radius: 12px; margin: 0 15px 15px 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div style="padding: 15px; border-bottom: 1px solid #f5f5f5;">
            <div style="font-weight: 600; font-size: 14px; color: #333;">Laporan</div>
        </div>

        <div
            style="display: grid; grid-template-columns: repeat(5, 1fr); padding: 20px 0; border-bottom: 1px solid #f5f5f5;">
            <div
                style="display: flex; flex-direction: column; align-items: center; text-align: center; cursor: pointer;">
                <i data-lucide="scan" style="width: 24px; height: 24px; color: #ee4d2d; margin-bottom: 8px;"></i>
                <span style="font-size: 11px; color: #333; margin-bottom: 4px;">ShopeePay</span>
                <span style="font-size: 10px; color: #ee4d2d;">Rp187.384</span>
            </div>
            <div
                style="display: flex; flex-direction: column; align-items: center; text-align: center; cursor: pointer;">
                <i data-lucide="coins" style="width: 24px; height: 24px; color: #fbc02d; margin-bottom: 8px;"></i>
                <span style="font-size: 11px; color: #333; margin-bottom: 4px;">Shopee Coins</span>
                <span style="font-size: 10px; color: #fbc02d;">0 Coins</span>
            </div>
            <div
                style="display: flex; flex-direction: column; align-items: center; text-align: center; cursor: pointer;">
                <i data-lucide="credit-card"
                    style="width: 24px; height: 24px; color: #ee4d2d; margin-bottom: 8px;"></i>
                <span style="font-size: 11px; color: #333; margin-bottom: 4px;">SPayLater</span>
                <span style="font-size: 9px; color: #ee4d2d; line-height: 1.2;">Get up to<br>Rp50.000.000</span>
            </div>
            <div
                style="display: flex; flex-direction: column; align-items: center; text-align: center; cursor: pointer;">
                <i data-lucide="banknote" style="width: 24px; height: 24px; color: #ee4d2d; margin-bottom: 8px;"></i>
                <span style="font-size: 11px; color: #333; margin-bottom: 4px;">SPinjam</span>
                <span style="font-size: 9px; color: #ee4d2d; line-height: 1.2;">Get up to<br>Rp12.000.000</span>
            </div>
            <div
                style="display: flex; flex-direction: column; align-items: center; text-align: center; cursor: pointer;">
                <i data-lucide="banknote" style="width: 24px; height: 24px; color: #ee4d2d; margin-bottom: 8px;"></i>
                <span style="font-size: 11px; color: #333; margin-bottom: 4px;">SPinjam</span>
                <span style="font-size: 9px; color: #ee4d2d; line-height: 1.2;">Get up to<br>Rp12.000.000</span>
            </div>
        </div>

        <div
            style="padding: 15px; display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <svg width="24" height="24" viewBox="0 0 100 100" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="50" fill="#ee4d2d" />
                    <path d="M25 50 C40 30, 60 70, 75 50" stroke="white" stroke-width="8" stroke-linecap="round" />
                </svg>
                <span style="font-size: 13px; color: #333; font-weight: 500;">SeaBank</span>
            </div>
            <div style="display: flex; align-items: center; gap: 6px;">
                <span style="font-size: 12px; color: #ee4d2d;">Enjoy Free Transfer</span>
                <i data-lucide="chevron-right" style="width: 16px; height: 16px; color: #9e9e9e;"></i>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <x-shopee-footer />

    <!-- Lucide Icons Script -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', ({
                el,
                component
            }) => {
                lucide.createIcons();
            });
        });
        document.addEventListener('livewire:navigated', () => {
            lucide.createIcons();
        });
    </script>
</div>
