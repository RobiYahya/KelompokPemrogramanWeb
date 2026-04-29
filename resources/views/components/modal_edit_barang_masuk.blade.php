<!-- Modal Edit Barang Masuk -->
<div id="modal-edit-barang-masuk" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Edit Incoming Item</h3>
            <button onclick="closeModal('modal-edit-barang-masuk')" class="modal-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form id="form-edit-barang-masuk" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_id_masuk">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="edit_barang_masuk" class="form-label">Item</label>
                        <select name="barang_id" id="edit_barang_masuk" class="form-input" required>
                            <option value="">Select Item</option>
                            @if(isset($barang))
                                @foreach($barang as $b)
                                <option value="{{ $b->id }}">{{ $b->nama }} (Stok: {{ $b->stok }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_jumlah_masuk" class="form-label">Quantity</label>
                        <input type="number" name="jumlah" id="edit_jumlah_masuk" min="1" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tanggal_masuk" class="form-label">Date</label>
                        <input type="date" name="tanggal" id="edit_tanggal_masuk" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_keterangan_masuk" class="form-label">Description</label>
                        <input type="text" name="keterangan" id="edit_keterangan_masuk" class="form-input" placeholder="Enter description">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-edit-barang-masuk')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModalMasuk(id, barangId, jumlah, tanggal, keterangan) {
    // Set form action URL (with admin prefix)
    const form = document.getElementById('form-edit-barang-masuk');
    form.action = '/admin/barang-masuk/' + id;
    
    // Fill form fields
    document.getElementById('edit_id_masuk').value = id;
    document.getElementById('edit_barang_masuk').value = barangId;
    document.getElementById('edit_jumlah_masuk').value = jumlah;
    document.getElementById('edit_tanggal_masuk').value = tanggal;
    document.getElementById('edit_keterangan_masuk').value = keterangan || '';
    
    // Open modal
    openModal('modal-edit-barang-masuk');
}
</script>