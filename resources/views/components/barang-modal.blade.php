@props(['mode', 'kategori', 'supplier'])

@php
    $modalId = $mode === 'edit' ? 'modal-barang-edit' : 'modal-barang';
    $title   = $mode === 'edit' ? 'Edit Item' : 'Add Item';
@endphp

<!-- Modal Barang ({{ $mode }}) -->
<div id="{{ $modalId }}" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">{{ $title }}</h3>
            <button onclick="closeModal('{{ $modalId }}')" class="modal-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            @if($mode === 'create')
                <form action="{{ route('barang.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="nama_barang" class="form-label">Item Name</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-input" placeholder="Enter item name" required>
                            @error('nama_barang')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kategori_barang" class="form-label">Category</label>
                            <select name="id_kategori" id="kategori_barang" class="form-input" required>
                                <option value="">Select Category</option>
                                @if(isset($kategori))
                                    @foreach($kategori as $k)
                                    <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('id_kategori')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="supplier_barang" class="form-label">Supplier</label>
                            <select name="id_supplier" id="supplier_barang" class="form-input" required>
                                <option value="">Select Supplier</option>
                                @if(isset($supplier))
                                    @foreach($supplier as $s)
                                    <option value="{{ $s->id_supplier }}">{{ $s->nama_supplier }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('id_supplier')
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
                            <input type="number" name="min_stok" id="minimum_stok_barang" value="10" class="form-input" required>
                            @error('min_stok')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="harga_beli_barang" class="form-label">Purchase Price</label>
                            <input type="number" name="harga" id="harga_beli_barang" class="form-input" placeholder="Enter purchase price" required>
                            @error('harga')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal('modal-barang')" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            @else
                <form id="form-edit-barang" action="" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="edit_nama_barang" class="form-label">Item Name</label>
                            <input type="text" name="nama_barang" id="edit_nama_barang" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_kategori_barang" class="form-label">Category</label>
                            <select name="id_kategori" id="edit_kategori_barang" class="form-input" required>
                                <option value="">Select Category</option>
                                @if(isset($kategori))
                                    @foreach($kategori as $k)
                                    <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_supplier_barang" class="form-label">Supplier</label>
                            <select name="id_supplier" id="edit_supplier_barang" class="form-input" required>
                                <option value="">Select Supplier</option>
                                @if(isset($supplier))
                                    @foreach($supplier as $s)
                                    <option value="{{ $s->id_supplier }}">{{ $s->nama_supplier }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_minimum_stok_barang" class="form-label">Minimum Stock</label>
                            <input type="number" name="min_stok" id="edit_minimum_stok_barang" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_harga_beli_barang" class="form-label">Purchase Price</label>
                            <input type="number" name="harga" id="edit_harga_beli_barang" class="form-input" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal('modal-barang-edit')" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

                <script>
                function openEditBarangModal(id, nama, kategoriId, supplierId, minimumStok, hargaBeli) {
                    document.getElementById('form-edit-barang').action = '{{ route('barang.update', ':id') }}'.replace(':id', id);
                    document.getElementById('edit_nama_barang').value = nama;
                    document.getElementById('edit_kategori_barang').value = kategoriId;
                    document.getElementById('edit_supplier_barang').value = supplierId;
                    document.getElementById('edit_minimum_stok_barang').value = minimumStok;
                    document.getElementById('edit_harga_beli_barang').value = hargaBeli;
                    openModal('modal-barang-edit');
                }
                </script>
            @endif
        </div>
    </div>
</div>