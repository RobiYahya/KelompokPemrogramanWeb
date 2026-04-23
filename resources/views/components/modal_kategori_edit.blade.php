<!-- Modal Edit Kategori -->
<div id="modal-kategori-edit" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Edit Kategori</h3>
            <button onclick="closeModal('modal-kategori-edit')" class="modal-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form id="form-edit-kategori" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" id="edit_nama_kategori" class="form-input" required>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-kategori-edit')" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditKategoriModal(id, nama) {
    document.getElementById('form-edit-kategori').action = '/admin/kategori/' + id;
    document.getElementById('edit_nama_kategori').value = nama;
    openModal('modal-kategori-edit');
}
</script>
