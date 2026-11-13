@extends('layouts.admin')

@section('title', 'Kelola Produk Parfum — Admin TGN Parfume')
@section('page-title', 'Manajemen Produk Parfum')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-secondary mb-0">
        @if(request('search'))
            {{ $products->count() }} produk cocok dengan pencarian
            &ldquo;{{ request('search') }}&rdquo;
            &mdash; <a href="{{ route('admin.products.index') }}" class="text-warning">Hapus filter</a>
        @else
            Total {{ $products->count() }} produk parfum tersimpan dalam koleksi MongoDB `tgn-parfume`
        @endif
    </p>
    <button type="button" class="btn btn-gradient rounded-3 px-3"
            data-bs-toggle="modal" data-bs-target="#product-form-modal" data-mode="create">
        <i class="bi bi-plus-lg me-1"></i> Tambah Parfum Baru
    </button>
</div>

@if($products->isEmpty())
    <div class="stat-card text-center p-5">
        <i class="bi bi-cup-hot fs-1 text-secondary mb-3 d-block"></i>
        <h4 class="fw-bold text-dark">Belum Ada Produk Parfum</h4>
        <p class="text-secondary">Produk yang ditambahkan akan tampil di sini.</p>
    </div>
@else
<div class="stat-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="border-bottom text-secondary small">
                    <th class="ps-4">Gambar</th>
                    <th>Nama Parfum</th>
                    <th>Kategori</th>
                    <th>Bahan Utama</th>
                    <th>Harga</th>
                    <th>Terjual</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-bottom">
                        <td class="ps-4 py-3">
                            <div class="bg-light p-1 rounded-3 text-center border" style="width: 50px; height: 50px;">
                                <img src="{{ asset('uploaded_img/' . trim($product->image)) }}" alt="{{ $product->name }}" class="img-fluid h-100" style="object-fit: contain;">
                            </div>
                        </td>
                        <td>
                            <h6 class="fw-bold text-dark mb-0">{{ $product->name }}</h6>
                            <span class="text-xs text-secondary text-truncate d-block" style="max-width: 200px;">{{ $product->details }}</span>
                        </td>
                        <td>
                            <span class="badge {{ strtolower($product->categories) === 'female' ? 'badge-female' : 'badge-category' }} rounded-pill px-2">
                                {{ ucfirst($product->categories) }}
                            </span>
                        </td>
                        <td class="text-slate-300 small">{{ $product->ingredient }}</td>
                        <td class="fw-bold text-warning">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="text-slate-300 small">{{ $product->sold ?? 0 }} pcs</td>
                        <td class="text-end pe-4">
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="button" class="btn btn-sm btn-outline-warning rounded-2 px-2" title="Edit Produk"
                                        data-bs-toggle="modal" data-bs-target="#product-form-modal" data-mode="edit"
                                        data-id="{{ $product->_id }}"
                                        data-name="{{ $product->name }}"
                                        data-details="{{ $product->details }}"
                                        data-categories="{{ strtolower($product->categories) }}"
                                        data-ingredient="{{ $product->ingredient }}"
                                        data-price="{{ $product->price }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.products.destroy', $product->_id) }}" method="POST"
                                      data-confirm
                                      data-confirm-title="Hapus Produk"
                                      data-confirm-text="Parfum &ldquo;{{ $product->name }}&rdquo; akan dihapus permanen. Lanjutkan?"
                                      data-confirm-accept="Ya, Hapus">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2 px-2" title="Hapus Produk">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Create/Edit modal: one form, hydrated by tgn-ui.js. Server-rendered old() values
     cover the failed-validation reopen. --}}
<div class="modal fade" id="product-form-modal" tabindex="-1" aria-labelledby="product-form-title" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="product-form-title">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Form Produk Parfum
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
                  data-store-route="{{ route('admin.products.store') }}"
                  data-update-route="{{ route('admin.products.update', ':id') }}">
                @csrf
                <input type="hidden" name="_method" value="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="pf-name" class="form-label text-slate-300 small fw-bold">Nama Parfum</label>
                            <input type="text" id="pf-name" name="name" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Contoh: Royal Musk" value="{{ old('name') }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="pf-categories" class="form-label text-slate-300 small fw-bold">Kategori Aroma</label>
                            <select id="pf-categories" name="categories" class="form-select @error('categories') is-invalid @enderror">
                                <option value="male" {{ old('categories') == 'male' ? 'selected' : '' }}>Pria (Male)</option>
                                <option value="female" {{ old('categories') == 'female' ? 'selected' : '' }}>Wanita (Female)</option>
                            </select>
                            @error('categories')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="pf-price" class="form-label text-slate-300 small fw-bold">Harga (Rp)</label>
                            <input type="number" id="pf-price" name="price" min="0" class="form-control @error('price') is-invalid @enderror"
                                   placeholder="75000" value="{{ old('price') }}">
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="pf-ingredient" class="form-label text-slate-300 small fw-bold">Bahan / Ingredient Utama</label>
                            <input type="text" id="pf-ingredient" name="ingredient" class="form-control @error('ingredient') is-invalid @enderror"
                                   placeholder="Contoh: Aqua (Water) &amp; Linalool" value="{{ old('ingredient') }}">
                            @error('ingredient')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12">
                            <label for="pf-details" class="form-label text-slate-300 small fw-bold">Deskripsi &amp; Catatan Aroma</label>
                            <textarea id="pf-details" name="details" rows="4" class="form-control @error('details') is-invalid @enderror"
                                      placeholder="Jelaskan karakteristik top, middle, dan base notes parfum...">{{ old('details') }}</textarea>
                            @error('details')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12">
                            <label for="pf-image" class="form-label text-slate-300 small fw-bold">Foto Produk Parfum (PNG/JPG/WEBP)</label>
                            <input type="file" id="pf-image" name="image" class="form-control @error('image') is-invalid @enderror"
                                    accept="image/jpeg,image/png,image/jpg,image/webp" required>
                            <div class="form-text text-secondary">Wajib saat menambah produk baru; biarkan kosong saat mengedit untuk mempertahankan foto lama.</div>
                            @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient px-4">
                        <i class="bi bi-save me-1"></i> Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
