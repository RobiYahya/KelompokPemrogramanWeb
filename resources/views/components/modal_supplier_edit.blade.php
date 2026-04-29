<!-- Modal Edit Supplier -->
<div id="modal-supplier-edit" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Edit Supplier</h3>
            <button onclick="closeModal('modal-supplier-edit')" class="modal-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form id="form-edit-supplier" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="edit_nama_supplier" class="form-label">Supplier Name</label>
                        <input type="text" name="nama" id="edit_nama_supplier" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_kontak_supplier" class="form-label">Contact</label>
                        <input type="text" name="kontak" id="edit_kontak_supplier" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="edit_telepon_supplier" class="form-label">Phone</label>
                        <input type="text" name="telepon" id="edit_telepon_supplier" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="edit_alamat_supplier" class="form-label">Address</label>
                        <input type="text" name="alamat" id="edit_alamat_supplier" class="form-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-supplier-edit')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditSupplierModal(id, nama, kontak, telepon, alamat) {
    document.getElementById('form-edit-supplier').action = '/admin/supplier/' + id;
    document.getElementById('edit_nama_supplier').value = nama;
    document.getElementById('edit_kontak_supplier').value = kontak || '';
    document.getElementById('edit_telepon_supplier').value = telepon || '';
    document.getElementById('edit_alamat_supplier').value = alamat || '';
    openModal('modal-supplier-edit');
}
</script>