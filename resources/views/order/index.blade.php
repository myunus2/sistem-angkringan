<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menu Angkringan Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {
            -webkit-appearance: none; margin: 0;
        }
        /* Menghilangkan scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        @media (max-width: 768px) {
            .snap-x-container {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scroll-behavior: smooth;
            }
            .snap-item {
                scroll-snap-align: start;
                flex-shrink: 0;
            }
        }
    </style>
</head>
<body class="bg-[#FDFDFD] pb-32">

    <div class="relative w-full h-64 md:h-80 bg-orange-500 overflow-hidden shadow-md">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
        <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=1200&q=80" 
             class="w-full h-full object-cover transform scale-105" alt="Banner Angkringan">
        <div class="absolute bottom-8 left-8 z-20 text-white">
            <h1 class="text-3xl md:text-4xl font-black tracking-tight drop-shadow-xl">Angkringan Modern</h1>
            <p class="text-sm md:text-base font-medium opacity-90 mt-1 flex items-center gap-2">
                <span>Jl. Utama No. 12</span>
            </p>
        </div>
    </div>

    <div class="px-4 mt-6">
        <form action="{{ route('index') }}" method="GET" class="relative">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="block w-full pl-10 pr-3 py-3 border-none bg-gray-100 rounded-2xl leading-5 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm transition-all" 
                   placeholder="Cari menu favoritmu...">
        </form>
    </div>

    <div class="px-4 my-6">
        <div id="nav-kategori" class="snap-x-container flex gap-3 pb-2 no-scrollbar overflow-x-auto justify-start md:justify-center">
            @php $currentCat = request('category', 'semua'); @endphp
            
            @foreach(['semua', 'makanan', 'minuman', 'snack'] as $cat)
            <div class="snap-item">
                <a href="{{ route('index', ['category' => $cat]) }}" 
                   class="category-btn inline-block whitespace-nowrap px-8 py-2.5 rounded-full text-sm font-bold transition-all 
                   {{ $currentCat == $cat ? 'bg-orange-500 text-white shadow-lg active-category' : 'bg-gray-100 text-gray-500' }}">
                   {{ ucfirst($cat) }}
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="w-full px-4 py-4">
        <h2 class="text-xl font-extrabold text-gray-800 mb-6 px-1 flex items-center gap-2">
            <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
            Daftar Menu {{ $currentCat !== 'semua' ? ucfirst($currentCat) : '' }}
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @forelse($products as $product)
            <div class="flex flex-col group">
                <div class="relative aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-gray-50 mb-2">
                    @if($product->images)
                        <img src="{{ asset('storage/' . $product->images) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-transform group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 font-bold uppercase text-[9px]">No Photo</div>
                    @endif
                </div>

                <div class="px-0.5">
                    <div class="mb-1">
                        @php
                            $badgeColor = match($product->type) {
                                'makanan' => 'bg-orange-100 text-orange-600',
                                'minuman' => 'bg-blue-100 text-blue-600',
                                'snack'   => 'bg-green-100 text-green-600',
                                default   => 'bg-gray-100 text-gray-600'
                            };
                        @endphp
                        <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded-md {{ $badgeColor }}">
                            {{ $product->type ?? 'Menu' }}
                        </span>
                    </div>

                    <h3 class="font-bold text-gray-800 text-sm leading-tight mb-0.5 truncate">{{ $product->name }}</h3>
                    <p class="text-sm font-bold text-orange-600 mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                    <div class="flex items-center justify-between bg-white border border-gray-200 rounded-lg p-0.5 shadow-sm">
                        <button onclick="decreaseQty(this)" class="w-8 h-8 flex items-center justify-center rounded-md text-orange-500 font-black hover:bg-orange-50">−</button>
                        <input type="number" value="0" min="0" max="{{ $product->stock }}" 
                               class="w-7 text-center bg-transparent font-black text-[10px] text-gray-800 qty-input"
                               data-id="{{ $product->id }}" data-price="{{ $product->price }}" readonly>
                        <button onclick="increaseQty(this)" class="w-8 h-8 flex items-center justify-center bg-orange-500 rounded-md text-white font-black shadow-sm active:scale-90">+</button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <p class="text-gray-400 font-medium">Menu tidak ditemukan... </p>
                <a href="{{ route('index') }}" class="text-orange-500 font-bold text-sm mt-2 block">Lihat Semua Menu</a>
            </div>
            @endforelse
        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 p-4 z-50">
        <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-xl border border-gray-100 flex items-center justify-between px-6">
            <div>
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Total Bayar</p>
                <p class="text-xl font-black text-gray-800" id="total-price">Rp 0</p>
            </div>
            <button onclick="openOrderModal()" class="bg-orange-500 hover:bg-orange-600 text-white font-black px-12 py-3.5 rounded-xl shadow-md transition-all active:scale-95 text-sm">
                PESAN 
            </button>
        </div>
    </div>

    <!-- Modal Form Pemesanan -->
    <div id="orderModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 z-[9999] flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]" id="modalContent">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4 rounded-t-2xl flex-shrink-0">
                <h2 class="text-xl font-black text-white">Konfirmasi Pesanan</h2>
            </div>

            <form id="orderForm" class="flex-1 overflow-y-auto p-6 space-y-5">
                @csrf
                
                <!-- Input Nama Pelanggan -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Pelanggan</label>
                    <input type="text" name="customer_name" id="customer_name" required
                           class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:outline-none transition-colors"
                           placeholder="Masukkan nama Anda...">
                </div>

                <!-- Input Nomor Meja -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Meja</label>
                    <input type="text" name="table_number" id="table_number" required
                           class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:outline-none transition-colors"
                           placeholder="Cth: Meja 1, Meja A, dll...">
                </div>

                <!-- Pilihan Metode Pembayaran -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Metode Pembayaran</label>
                    <div class="space-y-3">
                        <!-- Transfer Bank -->
                        <label class="flex items-start p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-orange-500 transition-colors">
                            <input type="radio" name="payment_method" value="transfer_bank" class="w-4 h-4 text-orange-500 mt-1 payment-method-radio" required>
                            <span class="ml-3 flex-1">
                                <span class="block font-bold text-gray-800">Transfer Bank</span>
                                <span class="block text-xs text-gray-500">BCA, Mandiri, BRI, dll</span>
                            </span>
                        </label>

                        <!-- E-Wallet -->
                        <label class="flex items-start p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-orange-500 transition-colors">
                            <input type="radio" name="payment_method" value="e_wallet" class="w-4 h-4 text-orange-500 mt-1 payment-method-radio" required>
                            <span class="ml-3 flex-1">
                                <span class="block font-bold text-gray-800">E-Wallet</span>
                                <span class="block text-xs text-gray-500">GoPay, OVO, Dana, dll</span>
                            </span>
                        </label>

                        <!-- Cash -->
                        <label class="flex items-start p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-orange-500 transition-colors">
                            <input type="radio" name="payment_method" value="cash" class="w-4 h-4 text-orange-500 mt-1 payment-method-radio" required>
                            <span class="ml-3 flex-1">
                                <span class="block font-bold text-gray-800">Uang Tunai</span>
                                <span class="block text-xs text-gray-500">Bayar di tempat</span>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Nomor Rekening Bank (Tampil jika pilih Transfer Bank) -->
                <div id="bankAccountSection" class="hidden bg-blue-50 border-2 border-blue-200 rounded-lg p-4">
                    <p class="block text-sm font-bold text-gray-700 mb-3">Data Rekening Bank</p>
                    <div id="bankAccountsList" class="space-y-2">
                        @forelse($bankAccounts as $account)
                        <div class="bg-white p-3 rounded-lg border border-blue-200">
                            <p class="font-bold text-gray-800">{{ $account->name }}</p>
                            <p class="text-sm text-gray-600">Nomor: <span class="font-mono font-bold">{{ $account->account_number }}</span></p>
                            <p class="text-sm text-gray-600">A/N: {{ $account->account_holder }}</p>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada rekening bank terdaftar</p>
                        @endforelse
                    </div>
                </div>

                <!-- Nomor E-Wallet (Tampil jika pilih E-Wallet) -->
                <div id="ewalletAccountSection" class="hidden bg-green-50 border-2 border-green-200 rounded-lg p-4">
                    <p class="block text-sm font-bold text-gray-700 mb-3">Data E-Wallet</p>
                    <div id="ewalletAccountsList" class="space-y-2">
                        @forelse($ewalletAccounts as $account)
                        <div class="bg-white p-3 rounded-lg border border-green-200">
                            <p class="font-bold text-gray-800">{{ $account->name }}</p>
                            <p class="text-sm text-gray-600">Nomor: <span class="font-mono font-bold">{{ $account->account_number }}</span></p>
                            <p class="text-sm text-gray-600">A/N: {{ $account->account_holder }}</p>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada e-wallet terdaftar</p>
                        @endforelse
                    </div>
                </div>

                <!-- Upload Bukti Pembayaran (Tampil jika pilih Bank atau E-Wallet) -->
                <div id="proofSection" class="hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Bukti Pembayaran</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-500 transition-colors cursor-pointer" id="dropZone">
                        <input type="file" name="proof_of_payment" id="proofInput" accept="image/*" class="hidden">
                        <p class="text-sm font-bold text-gray-700">Klik atau drag photo bukti transfer/pembayaran</p>
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Max 5MB)</p>
                        <div id="previewContainer" class="mt-3 hidden">
                            <img id="previewImage" src="" alt="Preview" class="w-full h-32 object-contain">
                        </div>
                    </div>
                </div>

                <!-- Total Harga -->
                <div class="bg-orange-50 border-2 border-orange-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                    <p class="text-2xl font-black text-orange-600" id="modalTotalPrice">Rp 0</p>
                </div>
            </form>

            <!-- Tombol Action (Fixed di Bottom) -->
            <div class="bg-white border-t border-gray-200 px-6 py-4 rounded-b-2xl flex gap-3 flex-shrink-0">
                <button type="button" onclick="closeOrderModal()" 
                        class="flex-1 px-4 py-2.5 border-2 border-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" form="orderForm"
                        class="flex-1 px-4 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-lg transition-colors">
                    Konfirmasi Pesanan
                </button>
            </div>
        </div>
    </div>

    <script>
        // Fitur Auto-Scroll ke Kategori Aktif
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById('nav-kategori');
            const activeBtn = document.querySelector('.active-category');
            
            if (activeBtn) {
                // Memberi sedikit delay agar browser siap melakukan scroll
                setTimeout(() => {
                    const offset = activeBtn.offsetLeft - (container.clientWidth / 2) + (activeBtn.clientWidth / 2);
                    container.scrollTo({
                        left: offset,
                        behavior: "smooth"
                    });
                }, 100);
            }

            // Setup form submission
            document.getElementById('orderForm').addEventListener('submit', submitOrder);

            // Setup payment method radio buttons
            document.querySelectorAll('.payment-method-radio').forEach(radio => {
                radio.addEventListener('change', function() {
                    updatePaymentDisplay();
                    setupFileUpload();
                });
            });

            // Setup file upload
            setupFileUpload();
        });

        // Fungsi untuk update tampilan berdasarkan payment method
        function updatePaymentDisplay() {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const bankSection = document.getElementById('bankAccountSection');
            const ewalletSection = document.getElementById('ewalletAccountSection');
            const proofSection = document.getElementById('proofSection');

            // Hide all sections first
            bankSection.classList.add('hidden');
            ewalletSection.classList.add('hidden');
            proofSection.classList.add('hidden');

            // Show relevant section
            if (selectedMethod === 'transfer_bank') {
                bankSection.classList.remove('hidden');
                proofSection.classList.remove('hidden');
            } else if (selectedMethod === 'e_wallet') {
                ewalletSection.classList.remove('hidden');
                proofSection.classList.remove('hidden');
            }

            // Clear file input and preview
            document.getElementById('proofInput').value = '';
            document.getElementById('previewContainer').classList.add('hidden');
        }

        // Fungsi untuk setup file upload
        function setupFileUpload() {
            const dropZone = document.getElementById('dropZone');
            const fileInput = document.getElementById('proofInput');
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');

            // Click to upload
            dropZone.addEventListener('click', () => fileInput.click());

            // Drag and drop
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-orange-500', 'bg-orange-50');
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('border-orange-500', 'bg-orange-50');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-orange-500', 'bg-orange-50');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    handleFileSelect(files[0]);
                }
            });

            // File input change
            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    handleFileSelect(e.target.files[0]);
                }
            });

            function handleFileSelect(file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Hanya file gambar yang diperbolehkan!');
                    fileInput.value = '';
                    return;
                }

                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file maksimal 5MB!');
                    fileInput.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        const inputs = document.querySelectorAll('.qty-input');
        
        function increaseQty(btn) {
            const input = btn.previousElementSibling;
            if(parseInt(input.value) < parseInt(input.max)) {
                input.value = parseInt(input.value) + 1;
                updateTotal();
            }
        }
        
        function decreaseQty(btn) {
            const input = btn.nextElementSibling;
            if(parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                updateTotal();
            }
        }
        
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.qty-input').forEach(i => {
                total += parseInt(i.value) * parseInt(i.dataset.price);
            });
            document.getElementById('total-price').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('modalTotalPrice').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        // Fungsi untuk membuka modal
        function openOrderModal() {
            let orderItems = [];
            let totalAll = 0;
            document.querySelectorAll('.qty-input').forEach(i => {
                if(i.value > 0) {
                    orderItems.push({ product_id: i.dataset.id, quantity: i.value });
                    totalAll += i.value * i.dataset.price;
                }
            });

            if(orderItems.length === 0) {
                alert('Pilih menu lezatnya dulu dong! ');
                return;
            }

            // Simpan data pesanan sementara
            window.currentOrder = {
                items: orderItems,
                total: totalAll
            };

            // Tampilkan modal dengan animasi
            const modal = document.getElementById('orderModal');
            const modalContent = document.getElementById('modalContent');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
            }, 10);

            // Update total harga di modal
            document.getElementById('modalTotalPrice').innerText = 'Rp ' + totalAll.toLocaleString('id-ID');
        }

        // Fungsi untuk menutup modal
        function closeOrderModal() {
            const modal = document.getElementById('orderModal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            }, 300);

            // Reset form
            document.getElementById('orderForm').reset();
            updatePaymentDisplay();
        }

        // Fungsi untuk submit order dari form
        function submitOrder(e) {
            e.preventDefault();

            try {
                const customerName = document.getElementById('customer_name').value;
                const tableNumber = document.getElementById('table_number').value;
                const paymentMethodEl = document.querySelector('input[name="payment_method"]:checked');
                const proofInput = document.getElementById('proofInput');

                if (!customerName || !tableNumber || !paymentMethodEl) {
                    alert('Lengkapi semua data terlebih dahulu! ');
                    return;
                }

                const paymentMethod = paymentMethodEl.value;

                // Check for proof if bank or ewallet
                if ((paymentMethod === 'transfer_bank' || paymentMethod === 'e_wallet') && !proofInput.files.length) {
                    alert('Bukti pembayaran harus diupload! ');
                    return;
                }

                // Validate currentOrder
                if (!window.currentOrder || !window.currentOrder.items || !Array.isArray(window.currentOrder.items)) {
                    alert('Data pesanan tidak valid! Silakan refresh halaman dan coba lagi.');
                    console.error('Invalid currentOrder:', window.currentOrder);
                    return;
                }

                if (window.currentOrder.items.length === 0) {
                    alert('Tidak ada item dalam pesanan!');
                    return;
                }

                // Gunakan FormData untuk support file upload
                const formData = new FormData();
                formData.append('customer_name', customerName);
                formData.append('table_number', tableNumber);
                formData.append('payment_method', paymentMethod);
                formData.append('total_price', window.currentOrder.total);
                
                console.log('Submitting order items:', window.currentOrder.items);
                
                // Append items array dengan format yang benar untuk FormData
                window.currentOrder.items.forEach((item, index) => {
                    formData.append(`items[${index}][product_id]`, item.product_id);
                    formData.append(`items[${index}][quantity]`, item.quantity);
                });
                
                // Tambah CSRF token
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}');

                // Tambah file jika ada
                if (proofInput.files.length > 0) {
                    formData.append('proof_of_payment', proofInput.files[0]);
                }

                // Show loading state
                const submitBtn = event.target.closest('form').querySelector('[type="submit"]');
                const originalText = submitBtn?.textContent;
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Mengirim...';
                }

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                fetch('{{ route("order.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(res => {
                    console.log('Response status:', res.status, 'ok:', res.ok);
                    // Handle both successful and error responses
                    if (res.ok) {
                        return res.json().then(data => {
                            console.log('Success response:', data);
                            return { data, ok: true };
                        });
                    } else {
                        return res.json().then(data => {
                            console.log('Error response:', data, 'status:', res.status);
                            return { data, ok: false };
                        });
                    }
                })
                .then(({ data, ok }) => {
                    console.log('Processing response: ok=', ok, 'data=', data);
                    if (ok && (data.message || data.success)) {
                        alert('Pesanan dikirim! Silakan tunggu di meja. ');
                        closeOrderModal();
                        // Reset quantities
                        document.querySelectorAll('.qty-input').forEach(input => {
                            input.value = 0;
                        });
                        updateTotal();
                        setTimeout(() => location.reload(), 500);
                    } else if (!ok) {
                        // Server returned error
                        let errorMessage = 'Terjadi kesalahan:\n\n';
                        
                        if (data && data.errors && typeof data.errors === 'object') {
                            // Validation errors
                            try {
                                for (const [field, messages] of Object.entries(data.errors)) {
                                    errorMessage += `• ${field}: ${Array.isArray(messages) ? messages.join(', ') : messages}\n`;
                                }
                            } catch (e) {
                                console.error('Error parsing validation errors:', e);
                                errorMessage = data.message || 'Gagal mengirim pesanan. Silakan coba lagi!';
                            }
                        } else if (data && data.message) {
                            errorMessage = data.message;
                        } else {
                            errorMessage = 'Gagal mengirim pesanan. Silakan coba lagi!';
                        }
                        
                        console.error('Server Error:', data);
                    }
                })
                .catch(err => {
                    console.error('Network Error:', err);
                })
                .finally(() => {
                    // Restore button state
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText || 'Konfirmasi Pesanan';
                    }
                });
            } catch (err) {
                console.error('Fatal error in submitOrder:', err);
              
            }
        }

        // Tutup modal saat klik di luar modal
        document.getElementById('orderModal').addEventListener('click', function(e) {
            if(e.target === this) {
                closeOrderModal();
            }
        });
    </script>
</body>
</html>