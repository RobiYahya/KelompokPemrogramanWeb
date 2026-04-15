<!-- Modal Supplier -->
<div id="modal-supplier" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Supplier</h3>
            <button onclick="closeModal('modal-supplier')" class="modal-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('supplier.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="nama_supplier" class="form-label">Nama Supplier</label>
                        <input type="text" name="nama" id="nama_supplier" class="form-input" placeholder="Masukkan nama supplier" required>
                        @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kontak_supplier" class="form-label">Kontak</label>
                        <input type="text" name="kontak" id="kontak_supplier" class="form-input" placeholder="Masukkan kontak">
                        @error('kontak')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="telepon_supplier" class="form-label">Telepon</label>
                        <input type="text" name="telepon" id="telepon_supplier" class="form-input" placeholder="Masukkan telepon">
                        @error('telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="alamat_supplier" class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat_supplier" class="form-input" placeholder="Masukkan alamat">
                        @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-supplier')" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
