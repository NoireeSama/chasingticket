@extends('layouts.admin')
@section('title', 'Tambah Event Baru - Admin')
@section('page_title', 'Tambah Event Baru')
@section('page_subtitle', 'Masukkan detail acara baru yang akan diselenggarakan.')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#103370] transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>Kembali ke Daftar Event</span>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    
    <div class="lg:col-span-2 bg-white p-8 md:p-10 rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] relative overflow-hidden">
        <div class="absolute -right-12 -top-12 w-64 h-64 bg-[#b8ff00]/20 rounded-full blur-3xl pointer-events-none"></div>

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
            @csrf

            <div>
                <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Judul Event</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" required placeholder="Misal: Jazz Night 2026">
                @error('title') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Kategori</label>
                <select name="category_id" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-bold text-slate-800 cursor-pointer" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-[25px] focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" placeholder="Tuliskan gambaran umum acara...">{{ old('description') }}</textarea>
                @error('description') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Tanggal & Waktu</label>
                    <input type="datetime-local" name="date" value="{{ old('date') }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" required>
                    @error('date') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location') }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" required placeholder="Misal: Amikom Hall">
                    @error('location') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" required min="0">
                    @error('price') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Kapasitas (Stok)</label>
                    <input type="number" name="stock" value="{{ old('stock', 1) }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" required min="1">
                    @error('stock') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Upload Poster Event (Opsional)</label>
                
                <div class="relative border-2 border-dashed border-slate-200 hover:border-[#103370] bg-slate-50/70 hover:bg-white rounded-[30px] p-6 text-center transition-all cursor-pointer group" onclick="document.getElementById('posterInput').click()">
                    <input type="file" id="posterInput" name="poster" accept="image/*" class="hidden" onchange="previewPoster(event)">
                    
                    <div id="uploadPlaceholder" class="space-y-2">
                        <div class="w-14 h-14 bg-[#103370]/10 text-[#103370] group-hover:bg-[#103370] group-hover:text-white rounded-full flex items-center justify-center mx-auto transition duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="font-bold text-slate-700 text-sm">Klik untuk memilih gambar poster event</p>
                        <p class="text-xs text-slate-400 font-medium">Format: PNG, JPG, WEBP (Rasio aspek 4:5 disarankan)</p>
                    </div>
                </div>
                @error('poster') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="p-6 bg-slate-50 rounded-[30px] border-2 border-[#f1f5f9] space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wide">Dynamic Pricing</label>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5">Aktifkan untuk meningkatkan harga tiket secara otomatis pada tanggal tertentu.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_dynamic_pricing" id="is_dynamic_pricing" value="1" class="sr-only peer" {{ old('is_dynamic_pricing') ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#103370]"></div>
                    </label>
                </div>

                <div id="dynamic-pricing-container" class="{{ old('is_dynamic_pricing') ? '' : 'hidden' }} space-y-4 pt-3 border-t border-slate-200">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-xs font-black text-slate-500 uppercase tracking-wider">Aturan Harga Dinamis (Maksimal 5)</p>
                    </div>
                    
                    <div id="rules-list" class="space-y-3">
                        
                    </div>
                    
                    <div class="flex items-center gap-3 pt-2">
                        <button type="button" id="add-rule-btn" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border-2 border-slate-200 hover:border-[#103370] hover:text-[#103370] rounded-full text-xs font-extrabold text-slate-600 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Dynamic Pricing
                        </button>
                        <button type="button" id="remove-last-rule-btn" class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-full text-xs font-extrabold transition shadow-sm" style="display: none;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path>
                            </svg>
                            Hapus Dynamic Pricing
                        </button>
                    </div>
                    @error('dynamic_pricing_rules')
                        <p class="text-red-500 text-sm font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-4 border-t border-slate-100">
                <a href="{{ route('admin.events.index') }}" class="px-6 py-3.5 text-slate-500 font-bold hover:text-[#103370] transition text-sm">Batal</a>
                <button type="submit" class="px-8 py-4 bg-[#103370] text-white font-bold rounded-full text-sm shadow-[0_10px_25px_rgba(16,51,112,0.3)] hover:bg-[#F24781] hover:shadow-[0_10px_25px_rgba(242,71,129,0.35)] transition duration-300 transform active:scale-98">Simpan Event</button>
            </div>
        </form>
    </div>

    <div class="lg:col-span-1 sticky top-6">
        <div class="bg-white p-6 rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-black text-[#103370]">Preview Poster</h3>
                <span id="previewStatusBadge" class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm">
                    Belum Pilih File
                </span>
            </div>

            @php
                $initialSrc = "data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='500' viewBox='0 0 400 500'%3E%3Crect width='400' height='500' fill='%23f1f5f9'/%3E%3Ctext x='50%25' y='48%25' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-weight='bold' font-size='20' fill='%23103370'%3EPreview Poster%3C/text%3E%3Ctext x='50%25' y='54%25' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='14' fill='%2394a3b8'%3ERasio 4:5%3C/text%3E%3C/svg%3E";
            @endphp

            <div class="relative w-full aspect-[4/5] rounded-[25px] overflow-hidden bg-slate-100 border-4 border-white shadow-md">
                <img id="posterPreview" src="{{ $initialSrc }}" data-default-src="{{ $initialSrc }}" alt="Preview Poster" class="w-full h-full object-cover transition-all duration-300">
            </div>

            <div class="p-4 bg-slate-50 rounded-[25px] border border-slate-100 space-y-1">
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Format Poster</p>
                <p class="text-xs font-semibold text-slate-600">Rasio aspek **4:5** disesuaikan otomatis dengan kartu event utama.</p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function previewPoster(event) {
        const input = event.target;
        const preview = document.getElementById('posterPreview');
        const badge = document.getElementById('previewStatusBadge');
        const defaultSrc = preview.getAttribute('data-default-src');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                if (badge) {
                    badge.innerText = 'Poster Dipilih';
                    badge.className = 'px-3 py-1 bg-[#F24781] text-white rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm';
                }
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = defaultSrc;
            if (badge) {
                badge.innerText = 'Belum Pilih File';
                badge.className = 'px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('is_dynamic_pricing');
        const container = document.getElementById('dynamic-pricing-container');
        const rulesList = document.getElementById('rules-list');
        const addBtn = document.getElementById('add-rule-btn');
        const removeLastBtn = document.getElementById('remove-last-rule-btn');
        const eventDateInput = document.getElementsByName('date')[0];
        const eventPriceInput = document.getElementsByName('price')[0];

        toggle.addEventListener('change', function() {
            if (this.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        });

        let ruleIndex = 0;

        function syncValidationAttributes() {
            const eventDateVal = eventDateInput.value;
            const eventPriceVal = eventPriceInput.value;

            rulesList.querySelectorAll('.rule-row').forEach(row => {
                const dateInput = row.querySelector('input[type="datetime-local"]');
                const priceInput = row.querySelector('input[type="number"]');

                if (eventDateVal) {
                    dateInput.setAttribute('max', eventDateVal);
                } else {
                    dateInput.removeAttribute('max');
                }

                if (eventPriceVal) {
                    priceInput.setAttribute('min', eventPriceVal);
                } else {
                    priceInput.setAttribute('min', '0');
                }
            });
        }

        eventDateInput.addEventListener('change', syncValidationAttributes);
        eventPriceInput.addEventListener('input', syncValidationAttributes);

        function addRule(dateVal = '', priceVal = '') {
            const rowsCount = rulesList.querySelectorAll('.rule-row').length;
            if (rowsCount >= 5) {
                alert('Maksimal 5 dynamic pricing yang diperbolehkan.');
                return;
            }

            const index = ruleIndex++;
            const row = document.createElement('div');
            row.className = 'rule-row flex items-center gap-3 bg-white p-3 rounded-[25px] border border-slate-200 shadow-sm relative';
            row.innerHTML = `
                <div class="flex-1 flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-400 whitespace-nowrap">Tanggal:</span>
                    <input type="datetime-local" name="dynamic_pricing_rules[${index}][date]" value="${dateVal}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-full text-xs font-semibold focus:ring-2 focus:ring-[#103370]/20 focus:border-[#103370] outline-none transition" required>
                </div>
                <div class="flex-1 flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-400 whitespace-nowrap">Harga Baru:</span>
                    <input type="number" name="dynamic_pricing_rules[${index}][price]" value="${priceVal}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-full text-xs font-semibold focus:ring-2 focus:ring-[#103370]/20 focus:border-[#103370] outline-none transition" placeholder="Misal: 120000" required min="0">
                </div>
                <button type="button" class="remove-rule-btn p-2 text-slate-400 hover:text-rose-600 transition" title="Hapus Aturan">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;

            row.querySelector('.remove-rule-btn').addEventListener('click', function() {
                row.remove();
                updateAddButtonVisibility();
            });

            rulesList.appendChild(row);
            syncValidationAttributes();
            updateAddButtonVisibility();
        }

        function updateAddButtonVisibility() {
            const rowsCount = rulesList.querySelectorAll('.rule-row').length;
            
            if (rowsCount >= 5) {
                addBtn.style.display = 'none';
            } else {
                addBtn.style.display = 'inline-flex';
            }

            if (rowsCount > 0) {
                removeLastBtn.style.display = 'inline-flex';
            } else {
                removeLastBtn.style.display = 'none';
            }
        }

        addBtn.addEventListener('click', function() {
            addRule();
        });

        removeLastBtn.addEventListener('click', function() {
            const rows = rulesList.querySelectorAll('.rule-row');
            if (rows.length > 0) {
                rows[rows.length - 1].remove();
                updateAddButtonVisibility();
            }
        });

        @if(old('dynamic_pricing_rules'))
            @foreach(old('dynamic_pricing_rules') as $rule)
                @if(!empty($rule['date']) || !empty($rule['price']))
                    addRule('{{ $rule['date'] }}', '{{ $rule['price'] }}');
                @endif
            @endforeach
        @endif
    });
</script>
@endsection
