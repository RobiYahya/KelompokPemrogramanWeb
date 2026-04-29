<!-- Modal Barang -->
<div id="modal-barang" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Add Item</h3>
            <button onclick="closeModal('modal-barang')" class="modal-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Item Name</label>
                        <input type="text" name="nama" id="nama_barang" class="form-input" placeholder="Enter item name" required>
                        @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kategori_barang" class="form-label">Category</label>
                        <select name="kategori_id" id="kategori_barang" class="form-input" required>
                            <option value="">Select Category</option>
                            @if(isset($kategori))
                                @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('kategori_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="supplier_barang" class="form-label">Supplier</label>
                        <select name="supplier_id" id="supplier_barang" class="form-input" required>
                            <option value="">Select Supplier</option>
                            @if(isset($supplier))
                                @foreach($supplier as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('supplier_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="stok_barang" class="form-label">Stock</label>
                        <input type="number" name="stok" id="stok_barang" value="0" class="form-input" required>
                        @error('stok')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="minimum_stok_barang" class="form-label">Minimum Stock</label>
                        <input type="number" name="minimum_stok" id="minimum_stok_barang" value="10" class="form-input" required>
                        @error('minimum_stok')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga_beli_barang" class="form-label">Purchase Price</label>
                        <input type="number" name="harga_beli" id="harga_beli_barang" class="form-input" placeholder="Enter purchase price" required>
                        @error('harga_beli')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-barang')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>