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
        $fieldType = filter_var($this->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

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

<div class="shopee-container" style="max-width: 450px; margin: 0 auto; background: white; min-height: 100vh; position: relative; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);">
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
