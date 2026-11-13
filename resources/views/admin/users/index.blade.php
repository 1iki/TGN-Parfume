@extends('layouts.admin')

@section('title', 'Kelola Pengguna — Admin TGN Parfume')
@section('page-title', 'Manajemen Pengguna & Staf Karyawan')

@section('content')
<!-- Staff / Admins Table -->
<div class="mb-5">
    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-shield-lock text-warning me-2"></i>Daftar Staf &amp; Administrator (Termasuk Karyawan yang Digabung)</h5>
    <div class="stat-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="border-bottom text-secondary small">
                        <th class="ps-4">Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Jabatan / Level</th>
                        <th>Status Akun</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr class="border-bottom">
                            <td class="ps-4 fw-bold text-dark">{{ $admin->username }}</td>
                            <td class="text-slate-300">{{ $admin->fullname }}</td>
                            <td class="text-slate-300">{{ $admin->email }}</td>
                            <td class="text-slate-300">{{ $admin->phone }}</td>
                            <td>
                                <span class="badge bg-light text-warning border border-warning px-2 py-1">
                                    {{ $admin->level }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $admin->status === 'Active' ? 'bg-success bg-opacity-25 text-success border border-success' : 'bg-danger bg-opacity-25 text-danger border border-danger' }}">
                                    {{ $admin->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <form action="{{ route('admin.users.toggleStatus', $admin->_id) }}" method="POST"
                                          data-confirm
                                          data-confirm-title="Ubah Status Akun"
                                          data-confirm-text="Status akun {{ $admin->username }} akan diubah menjadi {{ $admin->status === 'Active' ? 'Disable' : 'Active' }}."
                                          data-confirm-accept="Ya, Ubah">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Ubah Status Aktif/Disable">
                                            <i class="bi bi-power"></i>
                                        </button>
                                    </form>
                                    @if(Auth::id() !== $admin->_id)
                                        <form action="{{ route('admin.users.destroy', $admin->_id) }}" method="POST"
                                              data-confirm
                                              data-confirm-title="Hapus Akun Staf"
                                              data-confirm-text="Akun {{ $admin->username }} akan dihapus permanen. Lanjutkan?"
                                              data-confirm-accept="Ya, Hapus">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Akun">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-secondary py-4">Belum ada data staf.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Customer Users Table -->
<div>
    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-people text-primary me-2"></i>Daftar Akun Pelanggan (Consument)</h5>
    <div class="stat-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="border-bottom text-secondary small">
                        <th class="ps-4">Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-bottom">
                            <td class="ps-4 fw-bold text-dark">{{ $user->username }}</td>
                            <td class="text-slate-300">{{ $user->fullname }}</td>
                            <td class="text-slate-300">{{ $user->email }}</td>
                            <td class="text-slate-300">{{ $user->phone }}</td>
                            <td>
                                <span class="badge {{ $user->status === 'Active' ? 'bg-success bg-opacity-25 text-success border border-success' : 'bg-danger bg-opacity-25 text-danger border border-danger' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <form action="{{ route('admin.users.toggleStatus', $user->_id) }}" method="POST"
                                          data-confirm
                                          data-confirm-title="Ubah Status Akun"
                                          data-confirm-text="Status akun {{ $user->username }} akan diubah menjadi {{ $user->status === 'Active' ? 'Disable' : 'Active' }}."
                                          data-confirm-accept="Ya, Ubah">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Ubah Status">
                                            <i class="bi bi-power"></i> Toggle
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user->_id) }}" method="POST"
                                          data-confirm
                                          data-confirm-title="Hapus Akun Pelanggan"
                                          data-confirm-text="Pelanggan {{ $user->username }} akan dihapus permanen beserta aksesnya. Lanjutkan?"
                                          data-confirm-accept="Ya, Hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Akun">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-secondary py-4">Belum ada akun pelanggan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
