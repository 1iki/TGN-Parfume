/**
 * TGN Parfume — shared UI behavior (vanilla JS + Bootstrap 5).
 * Toasts, destructive-action confirmation modal, viewer/hydration modals.
 * No framework; included once by layouts.app and layouts.admin.
 */
(function () {
  'use strict';

  /* ---------------------------------------------------------------- toasts */
  function initToasts() {
    var container = document.getElementById('tgn-toasts');
    if (!container) return;
    container.querySelectorAll('.toast').forEach(function (el) {
      new bootstrap.Toast(el, { delay: 4500 }).show();
    });
  }

  /* ------------------------------------------------- confirmation modals */
  var confirmEl = null;
  var confirmModal = null;
  var pendingForm = null;

  function ensureConfirm() {
    if (!confirmEl) {
      confirmEl = document.getElementById('tgn-confirm-modal');
      if (!confirmEl) return false;
      confirmModal = new bootstrap.Modal(confirmEl);
    }
    return true;
  }

  function openConfirm(form) {
    pendingForm = form;
    if (!ensureConfirm()) { form.submit(); return; } /* graceful fallback */
    confirmEl.querySelector('#tgn-confirm-title').textContent =
      form.dataset.confirmTitle || 'Konfirmasi Tindakan';
    confirmEl.querySelector('#tgn-confirm-text').textContent =
      form.dataset.confirmText || 'Tindakan ini tidak dapat dibatalkan.';
    confirmEl.querySelector('#tgn-confirm-accept').textContent =
      form.dataset.confirmAccept || 'Ya, Lanjutkan';
    confirmModal.show();
  }

  /* Capture-phase: intercept flagged forms before the browser submits. */
  document.addEventListener('submit', function (e) {
    var f = e.target;
    if (f instanceof HTMLFormElement && f.hasAttribute('data-confirm') && !f.dataset.confirmed) {
      e.preventDefault();
      e.stopImmediatePropagation();
      openConfirm(f);
    }
  }, true);

  /* Status selects that need confirmation before cancelling an order. */
  var pendingSelect = null;
  var confirmAccepted = false;

  document.querySelectorAll('select[data-cancel-confirm="1"]').forEach(function (sel) {
    sel.addEventListener('focus', function () { sel.dataset.prev = sel.value; });
    sel.addEventListener('change', function () {
      var f = sel.closest('form');
      if (!f) return;
      if (sel.value === 'Cancelled' && !f.dataset.confirmed) {
        pendingSelect = sel;
        openConfirm(f);
        return;
      }
      sel.dataset.prev = sel.value;
      f.submit();
    });
  });

  /* Restore the select if the user backs out of the cancel confirmation. */
  document.addEventListener('hidden.bs.modal', function (e) {
    if (e.target !== confirmEl || !pendingSelect) return;
    if (!confirmAccepted && pendingSelect.dataset.prev !== undefined) {
      pendingSelect.value = pendingSelect.dataset.prev;
    }
    pendingSelect = null;
    confirmAccepted = false;
  });

  document.addEventListener('click', function (e) {
    if (!e.target.closest || !e.target.closest('#tgn-confirm-accept')) return;
    if (!pendingForm || !confirmEl) return;
    confirmAccepted = true;
    pendingForm.dataset.confirmed = '1';
    bootstrap.Modal.getInstance(confirmEl).hide();
    pendingForm.submit();
  });

  /* --------------------------------------- generic viewer/hydration modals */
  /* A trigger carries data-view-target="#id" plus data-<name> attributes;
     elements inside the modal carry data-fill="<name>" and receive the text,
     or render an <img> when they are one. */
  document.addEventListener('click', function (e) {
    var trigger = e.target.closest ? e.target.closest('[data-view-target]') : null;
    if (!trigger) return;
    var modal = document.getElementById(trigger.dataset.viewTarget);
    if (!modal) return;

    modal.querySelectorAll('[data-fill]').forEach(function (el) {
      var name = el.dataset.fill;
      var value = trigger.getAttribute('data-' + name) || '';
      if (el.tagName === 'IMG') {
        el.src = value;
        el.alt = name.charAt(0).toUpperCase() + name.slice(1);
      } else {
        el.textContent = value;
      }
    });
    modal.querySelectorAll('[data-fill-id]').forEach(function (el) {
      el.value = trigger.getAttribute('data-id') || '';
    });
    if (trigger.dataset.formAction) {
      var f = modal.querySelector('form');
      if (f) f.setAttribute('action', trigger.dataset.formAction);
    }
    new bootstrap.Modal(modal).show();
  });

  /* ------------------------------------------------- product create/edit */
  var productModal = document.getElementById('product-form-modal');

  function setProductMode(mode, id) {
    if (!productModal) return;
    var form = productModal.querySelector('form');
    var title = productModal.querySelector('#product-form-title');
    var file = form.querySelector('input[type="file"]');
    var method = form.querySelector('[name="_method"]');
    if (mode === 'edit') {
      title.textContent = 'Edit Data Parfum';
      method.value = 'PUT';
      form.setAttribute('action', form.dataset.updateRoute.replace(':id', id));
      file.removeAttribute('required');
    } else {
      title.textContent = 'Tambah Produk Parfum Baru';
      method.value = 'POST';
      form.setAttribute('action', form.dataset.storeRoute);
      form.reset();
      file.setAttribute('required', 'required');
    }
  }

  if (productModal) {
    /* Trigger buttons: data-bs-toggle="modal" data-mode="create|edit". */
    productModal.addEventListener('show.bs.modal', function (event) {
      var trigger = event.relatedTarget;
      if (!trigger) return; /* opened programmatically, state already set */
      setProductMode(trigger.dataset.mode || 'create', trigger.getAttribute('data-id') || '');
    });
  }

  /* Failed create/edit: reopen the modal with the server-rendered old() values. */
  var reopen = document.body.dataset.reopenProductForm;
  if (productModal && reopen) {
    setProductMode(reopen, document.body.dataset.reopenProductId || '');
    new bootstrap.Modal(productModal).show();
  }

  /* ----------------------------------------------------- fly-to-cart */
  /* Forms with data-fly-to="<selector>" play a short animation of the
     product image (plus a +qty badge) flying into the cart link, then
     submit. Keeps the plain POST flow; the page reload shows the toast. */
  document.querySelectorAll('form[data-fly-to]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (form.dataset.flying) return; /* replay submit passes through */
      e.preventDefault();
      e.stopImmediatePropagation();

      var target = document.querySelector(form.dataset.flyTo);
      var img = form.querySelector('[data-fly-image]') ||
                (form.closest('.glass-card, .card, section') || document).querySelector('img');
      var qty = form.querySelector('input[name="qty"], input[name="quantity"]');

      if (!target || !img || !img.getBoundingClientRect().width) {
        form.dataset.flying = '1';
        form.submit();
        return;
      }

      var from = img.getBoundingClientRect();
      var to = target.getBoundingClientRect();
      var count = Math.max(1, parseInt(qty && qty.value, 10) || 1);

      var ghost = img.cloneNode(false);
      ghost.className = '';
      ghost.style.cssText =
        'position:fixed;z-index:2100;pointer-events:none;margin:0;border-radius:12px;' +
        'object-fit:contain;box-shadow:0 10px 30px rgba(0,0,0,.25);' +
        'left:' + from.left + 'px;top:' + from.top + 'px;' +
        'width:' + from.width + 'px;height:' + from.height + 'px;';
      document.body.appendChild(ghost);

      var badge = document.createElement('div');
      badge.textContent = '+' + count;
      badge.setAttribute('aria-hidden', 'true');
      badge.style.cssText =
        'position:fixed;z-index:2101;pointer-events:none;background:#aa0000;color:#fff;' +
        'font-weight:700;border-radius:999px;padding:2px 10px;font-size:.8rem;' +
        'left:' + (from.left + from.width / 2 - 22) + 'px;top:' + (from.top - 12) + 'px;';
      document.body.appendChild(badge);

      var dx = (to.left + to.width / 2) - (from.left + from.width / 2);
      var dy = (to.top + to.height / 2) - (from.top + from.height / 2);

      var flight = ghost.animate([
        { transform: 'translate(0,0) scale(1)', opacity: 1 },
        { transform: 'translate(' + dx * 0.55 + 'px,' + (dy * 0.55 - 60) + 'px) scale(0.45)', opacity: 0.95, offset: 0.55 },
        { transform: 'translate(' + dx + 'px,' + dy + 'px) scale(0.12)', opacity: 0.25 }
      ], { duration: 700, easing: 'cubic-bezier(.55,0,.55,.2)' });

      badge.animate([
        { transform: 'translate(0,0) scale(1)', opacity: 1 },
        { transform: 'translate(' + dx * 0.6 + 'px,' + (dy * 0.6 - 30) + 'px) scale(1.3)', opacity: 0.9, offset: 0.55 },
        { transform: 'translate(' + dx + 'px,' + dy + 'px) scale(0.4)', opacity: 0 }
      ], { duration: 700, easing: 'ease-in' });

      flight.onfinish = function () {
        ghost.remove();
        badge.remove();
        target.animate(
          [{ transform: 'scale(1)' }, { transform: 'scale(1.25)' }, { transform: 'scale(1)' }],
          { duration: 280, easing: 'ease-out' }
        );
        form.dataset.flying = '1';
        form.submit();
      };
    });
  });

  /* Run now: this script loads at the end of <body>, so the DOM is there. */
  initToasts();
})();
