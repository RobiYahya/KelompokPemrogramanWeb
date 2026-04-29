<!-- Modal Edit Barang -->
<div id="modal-barang-edit" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Edit Item</h3>
            <button onclick="closeModal('modal-barang-edit')" class="modal-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form id="form-edit-barang" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="edit_nama_barang" class="form-label">Item Name</label>
                        <input type="text" name="nama" id="edit_nama_barang" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_kategori_barang" class="form-label">Category</label>
                        <select name="kategori_id" id="edit_kategori_barang" class="form-input" required>
                            <option value="">Select Category</option>
                            @if(isset($kategori))
                                @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_supplier_barang" class="form-label">Supplier</label>
                        <select name="supplier_id" id="edit_supplier_barang" class="form-input" required>
                            <option value="">Select Supplier</option>
                            @if(isset($supplier))
                                @foreach($supplier as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_stok_barang" class="form-label">Stock</label>
                        <input type="number" name="stok" id="edit_stok_barang" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_minimum_stok_barang" class="form-label">Minimum Stock</label>
                        <input type="number" name="minimum_stok" id="edit_minimum_stok_barang" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_harga_beli_barang" class="form-label">Purchase Price</label>
                        <input type="number" name="harga_beli" id="edit_harga_beli_barang" class="form-input" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-barang-edit')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditBarangModal(id, nama, kategoriId, supplierId, stok, minimumStok, hargaBeli) {
    document.getElementById('form-edit-barang').action = '/admin/barang/' + id;
    document.getElementById('edit_nama_barang').value = nama;
    document.getElementById('edit_kategori_barang').value = kategoriId;
    document.getElementById('edit_supplier_barang').value = supplierId;
    document.getElementById('edit_stok_barang').value = stok;
    document.getElementById('edit_minimum_stok_barang').value = minimumStok;
    document.getElementById('edit_harga_beli_barang').value = hargaBeli;
    openModal('modal-barang-edit');
}
</script>