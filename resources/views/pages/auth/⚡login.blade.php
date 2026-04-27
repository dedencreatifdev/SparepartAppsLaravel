<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

new #[Layout('layouts.app')] class extends Component
{
    #[Validate('required')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    public $showPassword = false;

    public function login()
    {
        $this->validate();

        // Check if input is email or username
        $fieldType = filter_var($this->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return $this->redirect('/', navigate: true);
        }

        $this->addError('email', 'Kredensial yang diberikan tidak cocok.');
    }
    
    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }
};
?>

<div class="shopee-container" style="max-width: 450px; margin: 0 auto; background: white; min-height: 100vh; position: relative; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;">
    <!-- Top Navigation -->
    <div class="top-bar" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #f0f0f0;">
        <i data-lucide="arrow-left" style="color: #ee4d2d; cursor: pointer;"></i>
        <span style="font-size: 18px; flex-grow: 1; margin-left: 15px;">Log In</span>
        <i data-lucide="help-circle" style="color: #757575; cursor: pointer;"></i>
    </div>

    <!-- Logo -->
    <div class="logo-container" style="display: flex; justify-content: center; margin: 40px 0;">
        <svg width="70" height="80" viewBox="0 0 100 110" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 35 L85 35 L75 95 L25 95 Z" fill="#ee4d2d"/>
            <path d="M35 35 V25 C35 10, 65 10, 65 25 V35" stroke="#ee4d2d" stroke-width="8" fill="none" stroke-linecap="round"/>
            <text x="50" y="78" font-family="Arial, sans-serif" font-size="45" fill="white" text-anchor="middle" font-weight="bold">S</text>
        </svg>
    </div>

    <!-- Login Form -->
    <form wire:submit="login" style="padding: 0 20px;">
        <!-- Email/Username -->
        <div class="input-group" style="display: flex; align-items: center; border-bottom: 1px solid #e0e0e0; padding: 10px 0; margin-bottom: 15px;">
            <i data-lucide="user" style="color: #9e9e9e; width: 20px; height: 20px; margin-right: 15px;"></i>
            <input type="text" wire:model.live="email" placeholder="No. Handphone/Email/Username" style="flex: 1; border: none; outline: none; font-size: 14px; padding: 5px 0;">
        </div>
        @error('email') <div style="color: red; font-size: 12px; margin-top: -10px; margin-bottom: 15px;">{{ $message }}</div> @enderror

        <!-- Password -->
        <div class="input-group" style="display: flex; align-items: center; border-bottom: 1px solid #e0e0e0; padding: 10px 0; margin-bottom: 25px;">
            <i data-lucide="lock" style="color: #9e9e9e; width: 20px; height: 20px; margin-right: 15px;"></i>
            <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model.live="password" placeholder="Password" style="flex: 1; border: none; outline: none; font-size: 14px; padding: 5px 0; width: 100%;">
            <i wire:click="togglePassword" data-lucide="{{ $showPassword ? 'eye' : 'eye-off' }}" style="color: #9e9e9e; width: 20px; height: 20px; margin-right: 15px; cursor: pointer;"></i>
            <span style="color: #0b5cff; font-size: 14px; font-weight: 500; cursor: pointer; border-left: 1px solid #e0e0e0; padding-left: 15px;">Lupa?</span>
        </div>
        @error('password') <div style="color: red; font-size: 12px; margin-top: -20px; margin-bottom: 20px;">{{ $message }}</div> @enderror

        <!-- Login Button -->
        <button type="submit" style="width: 100%; background: {{ $email && $password ? '#ee4d2d' : '#f5f5f5' }}; color: {{ $email && $password ? 'white' : '#bcbcbc' }}; border: none; padding: 12px; border-radius: 2px; font-size: 14px; font-weight: 500; cursor: {{ $email && $password ? 'pointer' : 'default' }}; pointer-events: {{ $email && $password ? 'auto' : 'none' }}; transition: all 0.2s;">
            Log In
        </button>
        
        <!-- Links -->
        <div style="display: flex; justify-content: space-between; margin-top: 15px; font-size: 13px;">
            <a href="#" style="color: #0b5cff; text-decoration: none;">Daftar</a>
            <a href="#" style="color: #0b5cff; text-decoration: none;">Log in dengan no. handphone</a>
        </div>
    </form>

    <!-- Divider -->
    <div class="divider" style="display: flex; align-items: center; text-align: center; margin: 25px 20px; color: #9e9e9e; font-size: 12px;">
        <hr style="flex: 1; border: none; border-top: 1px solid #e0e0e0;">
        <span style="padding: 0 15px;">ATAU</span>
        <hr style="flex: 1; border: none; border-top: 1px solid #e0e0e0;">
    </div>

    <!-- Social Logins -->
    <div class="social-logins" style="padding: 0 20px; display: flex; flex-direction: column; gap: 12px; padding-bottom: 30px;">
        <button type="button" style="display: flex; align-items: center; justify-content: center; background: #4285f4; color: white; border: none; padding: 10px; border-radius: 2px; font-size: 14px; position: relative; border: 1px solid #4285f4; cursor: pointer;">
            <div style="position: absolute; left: 1px; top: 1px; bottom: 1px; width: 40px; background: white; display: flex; align-items: center; justify-content: center; border-radius: 1px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
            </div>
            Lanjutkan dengan Google
        </button>
        <button type="button" style="display: flex; align-items: center; justify-content: center; background: #1877f2; color: white; border: none; padding: 10px; border-radius: 2px; font-size: 14px; position: relative; cursor: pointer;">
            <div style="position: absolute; left: 15px;">
                <svg width="18" height="18" viewBox="0 0 320 512" fill="white" xmlns="http://www.w3.org/2000/svg">
                    <path d="M279.1 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.4 0 225.4 0c-73.22 0-121.1 44.38-121.1 124.7v70.62H22.89V288h81.39v224h100.2V288z"/>
                </svg>
            </div>
            Lanjutkan dengan Facebook
        </button>
        <button type="button" style="display: flex; align-items: center; justify-content: center; background: #000000; color: white; border: none; padding: 10px; border-radius: 2px; font-size: 14px; position: relative; cursor: pointer;">
            <div style="position: absolute; left: 15px;">
                <svg width="18" height="18" viewBox="0 0 384 512" fill="white" xmlns="http://www.w3.org/2000/svg">
                    <path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"/>
                </svg>
            </div>
            Lanjutkan dengan Apple
        </button>
        <button type="button" style="display: flex; align-items: center; justify-content: center; background: #00c300; color: white; border: none; padding: 10px; border-radius: 2px; font-size: 14px; position: relative; cursor: pointer;">
            <div style="position: absolute; left: 15px;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.61 10.98c0-4.88-4.99-8.84-11.13-8.84C5.35 2.14.36 6.1.36 10.98c0 4.39 3.96 8.09 9.38 8.76.36.08.85.25.98.58.11.3-.03.77-.1 1.09l-.4 1.5c-.1.35-.46 1.47 1.28.74 1.74-.73 9.4-5.54 11.11-12.67z" fill="#00C300"/>
                    <text x="11.5" y="14" font-family="Arial, sans-serif" font-size="8" fill="white" text-anchor="middle" font-weight="bold">LINE</text>
                </svg>
            </div>
            Lanjutkan dengan Line
        </button>
    </div>

    <!-- Lucide Icons Script -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
        
        // Listen for livewire updates to re-initialize icons if DOM changes
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', ({ el, component }) => {
                lucide.createIcons();
            });
        });
    </script>
</div>