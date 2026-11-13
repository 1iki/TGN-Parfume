@extends('layouts.admin')

@section('title', 'Profil Administrator — Admin TGN Parfume')
@section('page-title', 'Profil Saya')

@section('content')
<div class="mb-4">
    <p class="text-secondary mb-0">Kelola informasi akun staf/administrator, foto profil, dan identitas sistem</p>
</div>

@if(session('success'))
    <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger mb-4" role="alert">
        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terjadi kesalahan:</div>
        <ul class="mb-0 ps-3 small">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-4">
    <!-- Admin Avatar & Overview Card -->
    <div class="col-xl-4">
        <div class="stat-card text-center p-4">
            <!-- Avatar with Interactive Camera Trigger -->
            <div class="position-relative d-inline-block mb-3">
                <img id="admin-avatar-preview" src="{{ $user->avatar_url }}" alt="Foto Profil"
                     class="rounded-circle img-thumbnail shadow-sm"
                     style="width: 140px; height: 140px; object-fit: cover;">
                <button type="button" class="btn btn-primary rounded-circle p-0 position-absolute bottom-0 end-0 shadow"
                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                        onclick="document.getElementById('admin_profile_image_input').click();"
                        title="Ganti Foto Profil">
                    <i class="bi bi-camera-fill"></i>
                </button>
            </div>

            <!-- Action Buttons & Status -->
            <div class="mb-3">
                <div class="d-flex flex-column gap-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('admin_profile_image_input').click();">
                        <i class="bi bi-upload me-1"></i> Pilih Foto Baru
                    </button>

                    @if($user->profile_image || $user->image)
                        <form action="{{ url('/Admin/users-profile.php') }}" method="POST"
                              data-confirm
                              data-confirm-title="Hapus Foto Profil"
                              data-confirm-text="Apakah Anda yakin ingin menghapus foto profil dan kembali ke avatar standar?"
                              data-confirm-accept="Ya, Hapus">
                            @csrf
                            <input type="hidden" name="remove_image" value="1">
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                <i class="bi bi-trash3 me-1"></i> Hapus Foto
                            </button>
                        </form>
                    @endif
                </div>

                <div id="admin-image-selection-badge" class="alert alert-info py-2 px-3 mt-3 mb-0 small d-none text-start">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-truncate me-2">
                            <i class="bi bi-image me-1"></i> <strong id="admin-selected-filename">foto.jpg</strong>
                        </span>
                        <button type="button" class="btn-close btn-sm" id="admin-btn-cancel-preview" aria-label="Batal"></button>
                    </div>
                    <div class="text-xs text-secondary mt-1">
                        <i class="bi bi-info-circle me-1"></i> Klik &ldquo;Simpan Perubahan&rdquo; untuk mengunggah.
                    </div>
                </div>

                <div class="text-secondary small mt-2">
                    Format: JPG, PNG, WEBP, GIF. Gambar dikompresi otomatis tanpa merusak kualitas pixel (maksimal hasil 3MB).
                </div>
            </div>

            <h4 class="fw-bold text-dark mb-1">{{ $user->fullname ?? $user->username }}</h4>
            <p class="text-secondary small mb-2"><i class="bi bi-person-badge me-1"></i>{{ $user->username }}</p>
            <span class="badge bg-light text-warning border border-warning px-3 py-2 rounded-pill">
                {{ $user->level ?? 'Administrator' }}
            </span>

            <hr class="my-4">

            <div class="text-start">
                <div class="mb-2">
                    <span class="text-secondary small d-block">Email Staf</span>
                    <span class="fw-bold text-dark"><i class="bi bi-envelope me-1 text-primary"></i> {{ $user->email }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-secondary small d-block">Nomor Telepon</span>
                    <span class="fw-bold text-dark"><i class="bi bi-telephone me-1 text-accent"></i> {{ $user->phone ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-secondary small d-block">Status Akun</span>
                    <span class="badge {{ $user->status === 'Active' ? 'bg-success bg-opacity-25 text-success border border-success' : 'bg-danger bg-opacity-25 text-danger border border-danger' }}">
                        {{ $user->status ?? 'Active' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Account Details Form -->
    <div class="col-xl-8">
        <div class="stat-card p-4 p-md-5">
            <h5 class="fw-bold text-dark mb-4"><i class="bi bi-sliders text-warning me-2"></i>Perbarui Informasi Administrator</h5>

            <form action="{{ url('/Admin/users-profile.php') }}" method="POST" enctype="multipart/form-data" id="admin-profile-form">
                @csrf

                <!-- Hidden file input linked to avatar picker -->
                <input type="file" id="admin_profile_image_input" name="profile_image" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-slate-300 small fw-bold" for="adm-fullname">Nama Lengkap</label>
                        <input class="form-control" id="adm-fullname" name="fullname" type="text" placeholder="Nama lengkap Anda" value="{{ old('fullname', $user->fullname) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-slate-300 small fw-bold" for="adm-username">Username</label>
                        <input class="form-control" id="adm-username" name="username" type="text" value="{{ $user->username }}" readonly disabled>
                        <span class="text-xs text-secondary">Username administrator bersifat permanen</span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-slate-300 small fw-bold" for="adm-email">Alamat Email</label>
                        <input class="form-control" id="adm-email" name="email" type="email" placeholder="admin@domain.com" value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-slate-300 small fw-bold" for="adm-phone">Nomor Telepon / WA</label>
                        <input class="form-control" id="adm-phone" name="phone" type="text" placeholder="08123456789" value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-slate-300 small fw-bold" for="adm-job">Jabatan / Role Operasional</label>
                        <input class="form-control" id="adm-job" name="job" type="text" placeholder="Contoh: Manajer Katalog &amp; Stok" value="{{ old('job', $user->job ?? $user->level) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-slate-300 small fw-bold" for="adm-country">Negara</label>
                        <input class="form-control" id="adm-country" name="country" type="text" placeholder="Indonesia" value="{{ old('country', $user->country ?? 'Indonesia') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label text-slate-300 small fw-bold" for="adm-address">Alamat Kantor / Domisili</label>
                        <input class="form-control" id="adm-address" name="address" type="text" placeholder="Alamat lengkap" value="{{ old('address', $user->address) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label text-slate-300 small fw-bold" for="adm-about">Deskripsi / Catatan Staf</label>
                        <textarea class="form-control" id="adm-about" rows="3" name="about" placeholder="Catatan tugas atau profil ringkas...">{{ old('about', $user->about) }}</textarea>
                    </div>

                    <div class="col-12 mt-4 d-flex flex-wrap gap-2">
                        <button class="btn btn-primary font-heading fw-bold px-4 py-2" type="submit" name="save_changes">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var fileInput = document.getElementById('admin_profile_image_input');
    var avatarPreview = document.getElementById('admin-avatar-preview');
    var badge = document.getElementById('admin-image-selection-badge');
    var filenameLabel = document.getElementById('admin-selected-filename');
    var cancelBtn = document.getElementById('admin-btn-cancel-preview');
    var defaultSrc = avatarPreview ? avatarPreview.src : '';

    if (fileInput && avatarPreview) {
        fileInput.addEventListener('change', function (e) {
            var file = e.target.files && e.target.files[0];
            if (!file) return;

            var validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'];
            if (validTypes.indexOf(file.type) === -1) {
                alert('Format file tidak didukung. Harap pilih gambar dengan format JPG, PNG, WEBP, atau GIF.');
                fileInput.value = '';
                return;
            }

            var objectUrl = URL.createObjectURL(file);
            avatarPreview.src = objectUrl;

            var sizeMb = (file.size / (1024 * 1024)).toFixed(2);
            if (filenameLabel) {
                filenameLabel.textContent = file.name + ' (' + sizeMb + ' MB)';
            }
            if (badge) {
                badge.classList.remove('d-none');
            }
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            if (fileInput) fileInput.value = '';
            if (avatarPreview) avatarPreview.src = defaultSrc;
            if (badge) badge.classList.add('d-none');
        });
    }
});
</script>
@endsection

