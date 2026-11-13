@extends('layouts.app')

@section('title', 'Profil Pengguna — TGN Parfume')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-extrabold mb-1">
            My Profile
        </h1>
        <p class="text-secondary mb-0">Kelola informasi data diri, foto profil, dan pengaturan akun Anda</p>
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
        <!-- Profile Picture & Overview Card -->
        <div class="col-lg-4">
            <div class="glass-card p-4 text-center">
                <!-- Avatar with Interactive Camera Trigger -->
                <div class="position-relative d-inline-block mb-3">
                    <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="Foto Profil"
                         class="rounded-circle img-thumbnail shadow-sm"
                         style="width: 140px; height: 140px; object-fit: cover;">
                    <button type="button" class="btn btn-primary rounded-circle p-0 position-absolute bottom-0 end-0 shadow"
                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                            onclick="document.getElementById('profile_image_input').click();"
                            title="Ganti Foto Profil">
                        <i class="bi bi-camera-fill"></i>
                    </button>
                </div>

                <!-- Action Buttons & Status -->
                <div class="mb-3">
                    <div class="d-flex flex-column gap-2">
                        <button type="button" class="btn btn-sm btn-outline-custom" onclick="document.getElementById('profile_image_input').click();">
                            <i class="bi bi-upload me-1"></i> Pilih Foto Baru
                        </button>

                        @if($user->profile_image || $user->image)
                            <form action="{{ url('/users-profile.php') }}" method="POST"
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

                    <div id="image-selection-badge" class="alert alert-info py-2 px-3 mt-3 mb-0 small d-none text-start">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-truncate me-2">
                                <i class="bi bi-image me-1"></i> <strong id="selected-filename">foto.jpg</strong>
                            </span>
                            <button type="button" class="btn-close btn-sm" id="btn-cancel-preview" aria-label="Batal"></button>
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
                <span class="badge badge-category rounded-pill px-3 py-2">
                    {{ ucfirst($user->level ?? 'Pelanggan') }}
                </span>
                
                <hr class="my-4">

                <div class="text-start">
                    <div class="mb-2">
                        <span class="text-secondary small d-block">Email</span>
                        <span class="fw-bold text-dark"><i class="bi bi-envelope me-1 text-primary"></i> {{ $user->email }}</span>
                    </div>
                    <div>
                        <span class="text-secondary small d-block">Nomor Telepon</span>
                        <span class="fw-bold text-dark"><i class="bi bi-telephone me-1 text-accent"></i> {{ $user->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account details form -->
        <div class="col-lg-8">
            <div class="glass-card p-4 p-md-5">
                <h4 class="fw-bold text-dark mb-4"><i class="bi bi-sliders text-accent me-2"></i>Perbarui Informasi Akun</h4>

                <form action="{{ url('/users-profile.php') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                    @csrf

                    <!-- Hidden file input linked to avatar picker -->
                    <input type="file" id="profile_image_input" name="profile_image" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="inputFullname">Nama Lengkap</label>
                            <input class="form-control" id="inputFullname" name="fullname" type="text" placeholder="Nama lengkap Anda" value="{{ old('fullname', $user->fullname) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="inputUsername">Username</label>
                            <input class="form-control" id="inputUsername" name="username" type="text" value="{{ $user->username }}" readonly disabled>
                            <span class="text-xs text-secondary">Username tidak dapat diubah</span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="inputEmail">Alamat Email</label>
                            <input class="form-control" id="inputEmail" name="email" type="email" placeholder="email@domain.com" value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="inputPhone">Nomor Telepon / WA</label>
                            <input class="form-control" id="inputPhone" name="phone" type="text" placeholder="08123456789" value="{{ old('phone', $user->phone) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="inputcountry">Negara</label>
                            <input class="form-control" id="inputcountry" name="country" type="text" placeholder="Indonesia" value="{{ old('country', $user->country ?? 'Indonesia') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="inputaddress">Alamat Pengiriman</label>
                            <input class="form-control" id="inputaddress" name="address" type="text" placeholder="Alamat pengiriman Anda" value="{{ old('address', $user->address) }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label text-slate-300 small fw-bold" for="inputabout">Tentang Saya</label>
                            <textarea class="form-control" id="inputabout" rows="3" name="about" placeholder="Deskripsi singkat profil Anda">{{ old('about', $user->about) }}</textarea>
                        </div>

                        <div class="col-12 mt-4 d-flex flex-wrap gap-2">
                            <button class="btn btn-gradient font-heading fw-bold px-4 py-2" type="submit" name="save_changes">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ url('/forgot-password.php') }}" class="btn btn-outline-custom font-heading px-4 py-2">
                                <i class="bi bi-shield-lock me-1"></i> Ganti Password
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var fileInput = document.getElementById('profile_image_input');
    var avatarPreview = document.getElementById('avatar-preview');
    var badge = document.getElementById('image-selection-badge');
    var filenameLabel = document.getElementById('selected-filename');
    var cancelBtn = document.getElementById('btn-cancel-preview');
    var defaultSrc = avatarPreview ? avatarPreview.src : '';

    if (fileInput && avatarPreview) {
        fileInput.addEventListener('change', function (e) {
            var file = e.target.files && e.target.files[0];
            if (!file) return;

            // Validate file type
            var validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'];
            if (validTypes.indexOf(file.type) === -1) {
                alert('Format file tidak didukung. Harap pilih file gambar dengan format JPG, PNG, WEBP, atau GIF.');
                fileInput.value = '';
                return;
            }

            // Real-time preview
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
