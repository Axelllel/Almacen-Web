import './bootstrap';
import Dropzone from 'dropzone';

// Prevent Dropzone from auto-discovering elements
Dropzone.autoDiscover = false;

// Initialize Dropzone on elements with class 'dropzone-upload'
document.addEventListener('DOMContentLoaded', function () {

    // ── Product Image Dropzone ──────────────────────────────────────────────
    const productDz = document.getElementById('product-dropzone');
    if (productDz) {
        const dz = new Dropzone('#product-dropzone', {
            url: '#',                   // overridden by form submit
            autoProcessQueue: false,
            maxFiles: 1,
            maxFilesize: 10,            // MB
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            dictDefaultMessage: `
                <div class="flex flex-col items-center gap-2">
                    <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-slate-400 font-medium">Arrastra la imagen aquí</span>
                    <span class="text-slate-500 text-xs">o haz click para seleccionar (máx. 10MB)</span>
                </div>`,
            dictRemoveFile: 'Eliminar',
            dictCancelUpload: 'Cancelar',
        });

        // On form submit, inject file into FormData
        const productForm = document.getElementById('product-form');
        if (productForm) {
            productForm.addEventListener('submit', function (e) {
                if (dz.files.length > 0) {
                    const fileInput = document.getElementById('imagen_hidden');
                    // Dropzone files are already in the form via the hidden input trick below
                }
            });

            // Append file to hidden input on file added
            dz.on('addedfile', function (file) {
                const dt = new DataTransfer();
                dt.items.add(file);
                document.getElementById('imagen').files = dt.files;
            });
            dz.on('removedfile', function () {
                document.getElementById('imagen').value = '';
            });
        }
    }

    // ── Exit Image Dropzone ─────────────────────────────────────────────────
    const exitDz = document.getElementById('exit-dropzone');
    if (exitDz) {
        const dz2 = new Dropzone('#exit-dropzone', {
            url: '#',
            autoProcessQueue: false,
            maxFiles: 1,
            maxFilesize: 10,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            dictDefaultMessage: `
                <div class="flex flex-col items-center gap-2">
                    <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-slate-400 font-medium">Comprobante de salida (opcional)</span>
                    <span class="text-slate-500 text-xs">Arrastra o haz click • máx. 10MB</span>
                </div>`,
            dictRemoveFile: 'Eliminar',
        });

        dz2.on('addedfile', function (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            const fi = document.getElementById('comprobante');
            if (fi) fi.files = dt.files;
        });
        dz2.on('removedfile', function () {
            const fi = document.getElementById('comprobante');
            if (fi) fi.value = '';
        });
    }

    // ── Auto-dismiss alerts ─────────────────────────────────────────────────
    const alerts = document.querySelectorAll('[data-auto-dismiss]');
    alerts.forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        }, 4000);
    });

    // ── Confirm delete ──────────────────────────────────────────────────────
    document.querySelectorAll('[data-confirm]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            if (!confirm(this.dataset.confirm)) e.preventDefault();
        });
    });
});
