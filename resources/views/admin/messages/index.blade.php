@extends('layouts.admin')

@section('title', 'Pesan Pelanggan — Admin TGN Parfume')
@section('page-title', 'Pesan & Masukan Pelanggan')

@section('content')
<div class="mb-4">
    <p class="text-secondary mb-0">Total {{ $messages->count() }} pesan tersimpan dalam MongoDB `messages` collection</p>
</div>

@if($messages->isEmpty())
    <div class="stat-card text-center p-5">
        <i class="bi bi-chat-dots fs-1 text-secondary mb-3 d-block"></i>
        <h4 class="fw-bold text-dark">Belum Ada Pesan Pelanggan</h4>
        <p class="text-secondary">Pesan yang dikirim dari halaman kontak akan muncul di sini.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($messages as $msg)
            <div class="col-md-6">
                <div class="stat-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                            <h6 class="fw-bold text-dark mb-0"><i class="bi bi-person me-2 text-accent"></i>{{ $msg->name }}</h6>
                            <span class="text-xs text-secondary"><i class="bi bi-telephone me-1"></i>{{ $msg->number }}</span>
                        </div>
                        <p class="text-slate-300 small mb-3"><i class="bi bi-envelope me-1 text-primary"></i> {{ $msg->email }}</p>
                        <div class="bg-light p-3 rounded-3 border mb-3">
                            <p class="text-dark mb-0 small text-truncate">{{ $msg->message }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-sm btn-outline-primary"
                                data-view-target="message-viewer-modal"
                                data-name="{{ $msg->name }}"
                                data-email="{{ $msg->email }}"
                                data-number="{{ $msg->number }}"
                                data-message="{{ $msg->message }}">
                            <i class="bi bi-envelope-open me-1"></i> Baca Pesan
                        </button>
                        <form action="{{ route('admin.messages.destroy', $msg->_id) }}" method="POST"
                              data-confirm
                              data-confirm-title="Hapus Pesan"
                              data-confirm-text="Pesan dari {{ $msg->name }} akan dihapus permanen. Lanjutkan?"
                              data-confirm-accept="Ya, Hapus">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash3 me-1"></i> Hapus Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Message detail viewer --}}
<div class="modal fade" id="message-viewer-modal" tabindex="-1" aria-labelledby="message-viewer-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="message-viewer-title"><i class="bi bi-envelope-open text-primary me-2"></i>Detail Pesan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <span class="text-secondary small d-block">Pengirim</span>
                    <h6 class="fw-bold text-dark mb-0" data-fill="name"></h6>
                    <span class="text-slate-300 small"><i class="bi bi-envelope me-1"></i><span data-fill="email"></span></span>
                    <span class="text-slate-300 small ms-3"><i class="bi bi-telephone me-1"></i><span data-fill="number"></span></span>
                </div>
                <div class="bg-light p-3 rounded-3 border">
                    <span class="text-secondary small d-block mb-1">Isi Pesan</span>
                    <p class="text-dark mb-0" data-fill="message" style="white-space: pre-line;"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
