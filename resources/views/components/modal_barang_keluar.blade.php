<!-- Modal Barang Keluar -->
<div id="modal-barang-keluar" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Add Outgoing Item</h3>
            <button onclick="closeModal('modal-barang-keluar')" class="modal-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('barang_keluar.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="barang_keluar" class="form-label">Item</label>
                        <select name="barang_id" id="barang_keluar" class="form-input" required>
                            <option value="">Select Item</option>
                            @if(isset($barang))
                                @foreach($barang as $b)
                                <option value="{{ $b->id }}">{{ $b->nama }} (Stok: {{ $b->stok }})</option>
                                @endforeach
                            @endif
                        </select>
                        @error('barang_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jumlah_keluar" class="form-label">Quantity</label>
                        <input type="number" name="jumlah" id="jumlah_keluar" value="1" min="1" class="form-input" required>
                        @error('jumlah')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_keluar" class="form-label">Date</label>
                        <input type="date" name="tanggal" id="tanggal_keluar" value="{{ date('Y-m-d') }}" class="form-input" required>
                        @error('tanggal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan_keluar" class="form-label">Description</label>
                        <input type="text" name="keterangan" id="keterangan_keluar" class="form-input" placeholder="Enter description">
                        @error('keterangan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-barang-keluar')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>