{{-- Shared destructive-action confirmation dialog.
     Driven by public/js/tgn-ui.js: any <form data-confirm data-confirm-title=".."
     data-confirm-text=".." data-confirm-accept=".."> opens this modal before submitting. --}}
<div class="modal fade" id="tgn-confirm-modal" tabindex="-1" aria-labelledby="tgn-confirm-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="fs-1 text-danger mb-2"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <h5 id="tgn-confirm-title" class="fw-bold mb-2">Konfirmasi Tindakan</h5>
                <p id="tgn-confirm-text" class="text-body-secondary small mb-0">
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="tgn-confirm-accept" class="btn btn-danger">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>

