<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

new class extends Component {
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $showImportModal = false;
    public $isEdit = false;
    public $productId;

    public $form = [
        'sku' => '',
        'name' => '',
        'description' => '',
        'price' => '',
        'discount_percent' => 0,
        'stock' => 0,
        'location' => '',
        'shipping_time' => '',
        'image' => '',
    ];

    public $importFile;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $id;
        $this->form = $product->only(['sku', 'name', 'description', 'price', 'discount_percent', 'stock', 'location', 'shipping_time', 'image']);
        // Ensure numeric values are numbers
        $this->form['price'] = (float) $this->form['price'];
        $this->form['discount_percent'] = (int) $this->form['discount_percent'];
        $this->form['stock'] = (int) $this->form['stock'];

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function resetForm()
    {
        $this->form = [
            'sku' => '',
            'name' => '',
            'description' => '',
            'price' => '',
            'discount_percent' => 0,
            'stock' => 0,
            'location' => '',
            'shipping_time' => '',
            'image' => '',
        ];
        $this->productId = null;
    }

    public function save()
    {
        $this->validate([
            'form.sku' => 'required|unique:products,sku,' . ($this->productId ?? 'NULL'),
            'form.name' => 'required',
            'form.price' => 'required|numeric',
        ]);

        $this->form['discount_amount'] = ($this->form['price'] * $this->form['discount_percent']) / 100;

        if ($this->isEdit) {
            Product::find($this->productId)->update($this->form);
        } else {
            Product::create($this->form);
        }

        $this->showModal = false;
        $this->dispatch('notify', ($this->isEdit ? 'Produk berhasil diubah!' : 'Produk berhasil ditambah!'));
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        $this->dispatch('notify', 'Produk berhasil dihapus!');
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function import()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new ProductsImport, $this->importFile);

        $this->showImportModal = false;
        $this->importFile = null;
        $this->dispatch('notify', 'Produk berhasil diimport!');

        return $this->redirect(route('produk.list'), navigate: true);
    }

    public function with()
    {
        return [
            'products' => Product::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('sku', 'like', '%' . $this->search . '%')
                ->latest()
                ->simplePaginate(),
        ];
    }
};
?>

@push('styles')
    @vite(['resources/css/shopee.css'])
    <style>
        .modal-slide-enter { transform: translateX(100%); }
        .modal-slide-enter-active { transform: translateX(0); transition: transform 0.5s ease-in-out; }
        .modal-slide-exit { transform: translateX(0); }
        .modal-slide-exit-active { transform: translateX(100%); transition: transform 0.5s ease-in-out; }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endpush

<div x-data="{ notification: '' }" @notify.window="notification = $event.detail; setTimeout(() => notification = '', 3000)">
    <!-- Global Loading Overlay -->
    <div wire:loading wire:target="import"
         class="fixed inset-0 z-[3000] flex flex-col items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm">
        <div class="flex flex-col items-center">
            <div style="width: 60px; height: 60px; border: 5px solid rgba(255,255,255,0.3); border-top: 5px solid #ee4d2d; border-radius: 50%; animation: spin 1s linear infinite;"></div>
            <p style="margin-top: 20px; color: white; font-weight: 700; font-size: 18px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">Sedang Mengimport Data...</p>
            <p style="margin-top: 8px; color: rgba(255,255,255,0.8); font-size: 13px;">Mohon tunggu sampai proses selesai</p>
        </div>
    </div>

    <!-- Notification -->
    <div x-show="notification"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="fixed bottom-20 left-1/2 transform -translate-x-1/2 z-[2000] bg-black bg-opacity-80 text-white px-6 py-3 rounded-full text-sm font-medium shadow-lg"
         style="white-space: nowrap;">
        <span x-text="notification"></span>
    </div>

    <!-- Main Container -->
    <div class="shopee-container" style="background: #f5f5f5; max-width: 450px; margin: 0 auto; min-height: 100vh; position: relative; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
        <!-- Top Nav -->
        <div class="top-nav" style="background: linear-gradient(to right, #ff5722, #ee4d2d); padding: 10px 15px; display: flex; align-items: center; gap: 12px; position: sticky; top: 0; z-index: 100;">
            <a href="{{ route('profile') }}" wire:navigate style="color: white; display: flex; align-items: center;">
                <i data-lucide="chevron-left"></i>
            </a>
            <div class="search-container" style="flex: 1; position: relative; display: flex; align-items: center;">
                <i data-lucide="search" style="position: absolute; left: 10px; width: 16px; height: 16px; color: #ffff;"></i>
                <input type="text" wire:model.live="search"
                       style="color:#ffff; width: 100%; height: 32px; border-radius: 4px; border: 1px solid #e0e0e0; padding: 0 10px 0 35px; font-size: 12px; outline: none;"
                       placeholder="Cari SKU atau Nama Produk">
            </div>
            <div style="display: flex; gap: 12px; color: white;">
                <i data-lucide="download" @click="$wire.export()" style="cursor: pointer; width: 22px; height: 22px;"></i>
                <i data-lucide="upload" @click="$wire.showImportModal = true" style="cursor: pointer; width: 22px; height: 22px;"></i>
            </div>
        </div>

        <!-- Action Bar -->
        <div style="background: white; padding: 12px 15px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee;">
            <div style="font-weight: 700; color: #333; font-size: 15px;">Daftar Produk</div>
            <button @click="$wire.openModal()"
                    style="background: #ee4d2d; color: white; border: none; padding: 6px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; box-shadow: 0 2px 4px rgba(238, 77, 45, 0.2);">
                <i data-lucide="plus" style="width: 14px; height: 14px;"></i> Tambah
            </button>
        </div>

        <!-- Product List -->
        <div style="padding-bottom: 80px;">
            @forelse($products as $product)
                <div style="background: white; margin-top: 8px; padding: 15px; display: flex; gap: 15px; position: relative; transition: background 0.2s;"
                     class="hover:bg-gray-50">
                    <div style="width: 85px; height: 85px; background: #f8f8f8; border-radius: 6px; overflow: hidden; border: 1px solid #f0f0f0; flex-shrink: 0;">
                        @if($product->image)
                            <img src="{{ $product->image }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ddd; background: #fafafa;">
                                <i data-lucide="image" style="width: 30px; height: 30px;"></i>
                            </div>
                        @endif
                    </div>
                    <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="font-size: 14px; color: #222; font-weight: 600; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                                {{ $product->name }}
                            </div>
                            <div style="font-size: 11px; color: #757575; margin-bottom: 8px; display: flex; align-items: center; gap: 4px;">
                                <span style="background: #f5f5f5; padding: 2px 6px; border-radius: 2px;">SKU: {{ $product->sku }}</span>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                            <div>
                                <div style="color: #ee4d2d; font-weight: 700; font-size: 17px;">
                                    <span style="font-size: 12px; font-weight: 600;">Rp</span>{{ number_format($product->price, 0, ',', '.') }}
                                </div>
                                <div style="font-size: 11px; color: #757575; margin-top: 2px;">Stok: <span style="color: {{ $product->stock > 0 ? '#4caf50' : '#f44336' }}; font-weight: 600;">{{ $product->stock }}</span></div>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <button @click="$wire.edit({{ $product->id }})"
                                        style="background: #f0f7ff; border: none; color: #007bff; cursor: pointer; padding: 8px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                    <i data-lucide="edit-3" style="width: 18px; height: 18px;"></i>
                                </button>
                                <button @click="if(confirm('Hapus produk ini?')) $wire.delete({{ $product->id }})"
                                        style="background: #fff5f5; border: none; color: #ff4d4f; cursor: pointer; padding: 8px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                    <i data-lucide="trash-2" style="width: 18px; height: 18px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding: 100px 20px; text-align: center; color: #999;">
                    <i data-lucide="package-search" style="width: 60px; height: 60px; margin: 0 auto 15px; opacity: 0.3;"></i>
                    <p style="font-size: 14px;">Belum ada produk yang ditemukan</p>
                </div>
            @endforelse

            <div style="padding: 20px; display: flex; justify-content: center;">
                {{ $products->links() }}
            </div>
        </div>

        <!-- Slide-over Modal CRUD (Slide from Right, h-full, w-450) -->
        <div x-show="$wire.showModal"
             class="fixed inset-0 z-[1500] overflow-hidden"
             style="display: none;"
             @keydown.escape.window="$wire.showModal = false">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity"
                 x-show="$wire.showModal"
                 x-transition:enter="ease-out duration-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-400"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="$wire.showModal = false"></div>

            <div class="fixed inset-y-0 right-0 flex max-w-full">
                <!-- Modal Panel -->
                <div x-show="$wire.showModal"
                     x-transition:enter="transform transition ease-in-out duration-500"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="w-screen max-w-[450px] bg-white h-full shadow-2xl flex flex-col relative">

                    <!-- Header -->
                    <div style="padding: 18px 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: white; position: sticky; top: 0; z-index: 10;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 4px; height: 18px; background: #ee4d2d; border-radius: 2px;"></div>
                            <div style="font-weight: 700; font-size: 17px; color: #222;" x-text="$wire.isEdit ? 'Ubah Informasi Produk' : 'Tambah Produk Baru'"></div>
                        </div>
                        <button @click="$wire.showModal = false" style="background: #f5f5f5; border: none; padding: 6px; border-radius: 50%; cursor: pointer; color: #757575; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="x" style="width: 20px; height: 20px;"></i>
                        </button>
                    </div>

                    <!-- Form Content -->
                    <div style="flex: 1; overflow-y: auto; padding: 25px 20px; background: #fafafa;">
                        <form wire:submit.prevent="save" id="productForm">
                            <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #f0f0f0; margin-bottom: 20px;">
                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Nama Produk <span style="color: #ee4d2d;">*</span></label>
                                    <input type="text" wire:model="form.name"
                                           style="width: 100%; border: 1px solid #e0e0e0; padding: 8px 12px; border-radius: 6px; font-size: 13px; outline: none; transition: border-color 0.2s;"
                                           class="focus:border-orange-500 text-sm" placeholder="Masukkan nama produk">
                                    @error('form.name') <span style="color: #ee4d2d; font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                                </div>

                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">SKU / Kode Produk <span style="color: #ee4d2d;">*</span></label>
                                    <input type="text" wire:model="form.sku"
                                           style="width: 100%; border: 1px solid #e0e0e0; padding: 8px 12px; border-radius: 6px; font-size: 13px; outline: none;"
                                           class="focus:border-orange-500 text-sm" placeholder="Contoh: PROD-001">
                                    @error('form.sku') <span style="color: #ee4d2d; font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                                </div>

                                <div style="margin-bottom: 0;">
                                    <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Harga Jual (Rp) <span style="color: #ee4d2d;">*</span></label>
                                    <div style="position: relative;">
                                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 14px; font-weight: 600; color: #999;">Rp</span>
                                        <input type="number" wire:model="form.price"
                                               style="width: 100%; border: 1px solid #e0e0e0; padding: 8px 12px 8px 40px; border-radius: 6px; font-size: 13px; outline: none; font-weight: 600;"
                                               class="focus:border-orange-500 text-sm">
                                    </div>
                                    @error('form.price') <span style="color: #ee4d2d; font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #f0f0f0; margin-bottom: 20px;">
                                <div style="display: flex; gap: 15px; margin-bottom: 0;">
                                    <div style="flex: 1;">
                                        <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Diskon (%)</label>
                                        <div style="position: relative;">
                                            <input type="number" wire:model="form.discount_percent"
                                                   style="width: 100%; border: 1px solid #e0e0e0; padding: 8px 12px; border-radius: 6px; font-size: 13px; outline: none;"
                                                   class="focus:border-orange-500 text-sm">
                                            <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 14px; color: #999;">%</span>
                                        </div>
                                    </div>
                                    <div style="flex: 1;">
                                        <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Stok</label>
                                        <input type="number" wire:model="form.stock"
                                               style="width: 100%; border: 1px solid #e0e0e0; padding: 8px 12px; border-radius: 6px; font-size: 13px; outline: none;"
                                               class="focus:border-orange-500 text-sm">
                                    </div>
                                </div>
                            </div>

                            <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #f0f0f0; margin-bottom: 20px;">
                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Deskripsi Produk</label>
                                    <textarea wire:model="form.description"
                                              style="width: 100%; border: 1px solid #e0e0e0; padding: 8px 12px; border-radius: 6px; font-size: 13px; outline: none; min-height: 80px; resize: none;"
                                              class="focus:border-orange-500 text-sm" placeholder="Tuliskan detail produk..."></textarea>
                                </div>

                                <div style="display: flex; gap: 15px;">
                                    <div style="flex: 1;">
                                        <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Lokasi</label>
                                        <input type="text" wire:model="form.location"
                                               style="width: 100%; border: 1px solid #e0e0e0; padding: 8px 12px; border-radius: 6px; font-size: 13px; outline: none;"
                                               placeholder="Kota">
                                    </div>
                                    <div style="flex: 1;">
                                        <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Pengiriman</label>
                                        <input type="text" wire:model="form.shipping_time"
                                               style="width: 100%; border: 1px solid #e0e0e0; padding: 8px 12px; border-radius: 6px; font-size: 13px; outline: none;"
                                               placeholder="Estimasi">
                                    </div>
                                </div>
                            </div>

                            <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #f0f0f0; margin-bottom: 30px;">
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">URL Gambar Produk</label>
                                <input type="text" wire:model="form.image"
                                       style="width: 100%; border: 1px solid #e0e0e0; padding: 8px 12px; border-radius: 6px; font-size: 13px; outline: none;"
                                       placeholder="https://example.com/image.jpg">
                                <div style="margin-top: 15px; width: 100%; height: 150px; background: #f9f9f9; border: 2px dashed #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    @if($form['image'])
                                        <img src="{{ $form['image'] }}" style="width: 100%; height: 100%; object-fit: contain;">
                                    @else
                                        <div style="text-align: center; color: #bbb;">
                                            <i data-lucide="image-plus" style="width: 32px; height: 32px; margin: 0 auto 8px;"></i>
                                            <p style="font-size: 11px;">Preview Gambar</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div style="padding: 20px; background: white; border-top: 1px solid #eee; display: flex; gap: 12px; position: sticky; bottom: 0;">
                        <button type="button" @click="$wire.showModal = false"
                                style="flex: 1; background: #f5f5f5; color: #555; border: none; padding: 10px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 13px;">
                            Batal
                        </button>
                        <button type="submit" form="productForm"
                                style="flex: 2; background: #ee4d2d; color: white; border: none; padding: 10px; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 13px; box-shadow: 0 4px 12px rgba(238, 77, 45, 0.3);">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Import Modal (Centered) -->
        <div x-show="$wire.showImportModal"
             class="fixed inset-0 z-[1600] flex items-center justify-center p-4"
             style="display: none;">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="$wire.showImportModal = false"></div>
            <div class="bg-white rounded-2xl p-8 max-w-sm w-full relative z-[1601] shadow-2xl overflow-hidden">
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="width: 60px; height: 60px; background: #e6f7ff; color: #1890ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i data-lucide="file-spreadsheet" style="width: 30px; height: 30px;"></i>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 700; color: #222;">Import Excel</h3>
                    <p style="font-size: 13px; color: #757575; margin-top: 5px;">Pilih file .xlsx atau .xls untuk mengunggah daftar produk sekaligus.</p>
                </div>

                <div style="margin-bottom: 25px;">
                    <div style="border: 2px dashed #e0e0e0; padding: 20px; border-radius: 12px; text-align: center; position: relative; background: #fafafa;">
                        <input type="file" wire:model="importFile"
                               style="position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;">
                        @if($importFile)
                            <div style="color: #4caf50;">
                                <i data-lucide="check-circle" style="width: 24px; height: 24px; margin: 0 auto 8px;"></i>
                                <p style="font-size: 12px; font-weight: 600;">{{ $importFile->getClientOriginalName() }}</p>
                            </div>
                        @else
                            <div style="color: #999;">
                                <i data-lucide="plus-circle" style="width: 24px; height: 24px; margin: 0 auto 8px;"></i>
                                <p style="font-size: 12px;">Klik untuk pilih file</p>
                            </div>
                        @endif
                    </div>
                    @error('importFile') <p style="color: #ee4d2d; font-size: 11px; margin-top: 8px; text-align: center;">{{ $message }}</p> @enderror
                </div>

                <div style="display: flex; gap: 12px;">
                    <button @click="$wire.showImportModal = false"
                            style="flex: 1; background: #f5f5f5; color: #555; border: none; padding: 10px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px;">
                        Batal
                    </button>
                    <button @click="$wire.import()"
                            wire:loading.attr="disabled"
                            wire:target="import"
                            style="flex: 1; background: #1890ff; color: white; border: none; padding: 10px; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 13px; box-shadow: 0 4px 12px rgba(24, 144, 255, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <span wire:loading.remove wire:target="import">Import</span>
                        <span wire:loading wire:target="import">Processing...</span>
                    </button>
                </div>
            </div>
        </div>

        <x-shopee-footer />
    </div>

    <!-- Lucide Icons Script -->
    <script>
        document.addEventListener('livewire:navigated', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', (el, component) => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        });
    </script>
</div>
