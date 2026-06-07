@props(['type', 'mode', 'barang'])

@php
    $modalId = $mode === 'edit' ? "modal-edit-barang-{$type}" : "modal-barang-{$type}";
    $formId  = "form-edit-barang-{$type}";
    $selectId = $mode === 'edit' ? "edit_barang_{$type}" : "barang_{$type}";
    $hiddenId = "edit_id_{$type}";

    if ($type === 'masuk') {
        $title = $mode === 'edit' ? 'Edit Incoming Item' : 'Add Incoming Item';
    } else {
        $title = $mode === 'edit' ? 'Edit Outgoing Item' : 'Add Outgoing Item';
    }

    $jumlahId    = $mode === 'edit' ? "edit_jumlah_{$type}"    : "jumlah_{$type}";
    $tanggalId   = $mode === 'edit' ? "edit_tanggal_{$type}"   : "tanggal_{$type}";
    $keteranganId = $mode === 'edit' ? "edit_keterangan_{$type}" : "keterangan_{$type}";
@endphp

<!-- Modal Stock Transaction ({{ $type }} / {{ $mode }}) -->
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
                <form action="{{ $type === 'masuk' ? route('barang_masuk.store') : route('barang_keluar.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="{{ $selectId }}" class="form-label">Item</label>
                            <select name="id_barang" id="{{ $selectId }}" class="form-input" required>
                                <option value="">Select Item</option>
                                @if(isset($barang))
                                    @foreach($barang as $b)
                                    <option value="{{ $b->id_barang }}">{{ $b->nama_barang }} (Stock: {{ $b->stok }})</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('id_barang')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="{{ $jumlahId }}" class="form-label">Quantity</label>
                            <input type="number" name="jumlah" id="{{ $jumlahId }}" value="1" min="1" class="form-input" required>
                            @error('jumlah')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="{{ $tanggalId }}" class="form-label">Date</label>
                            <input type="date" name="tanggal" id="{{ $tanggalId }}" value="{{ date('Y-m-d') }}" class="form-input" required>
                            @error('tanggal')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="{{ $keteranganId }}" class="form-label">Description</label>
                            <input type="text" name="deskripsi" id="{{ $keteranganId }}" class="form-input" placeholder="Enter description">
                            @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal('{{ $modalId }}')" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            @else
                <form id="{{ $formId }}" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="{{ $hiddenId }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="{{ $selectId }}" class="form-label">Item</label>
                            <select name="id_barang" id="{{ $selectId }}" class="form-input" required>
                                <option value="">Select Item</option>
                                @if(isset($barang))
                                    @foreach($barang as $b)
                                    <option value="{{ $b->id_barang }}">{{ $b->nama_barang }} (Stock: {{ $b->stok }})</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="{{ $jumlahId }}" class="form-label">Quantity</label>
                            <input type="number" name="jumlah" id="{{ $jumlahId }}" min="1" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="{{ $tanggalId }}" class="form-label">Date</label>
                            <input type="date" name="tanggal" id="{{ $tanggalId }}" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="{{ $keteranganId }}" class="form-label">Description</label>
                            <input type="text" name="deskripsi" id="{{ $keteranganId }}" class="form-input" placeholder="Enter description">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal('{{ $modalId }}')" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

                @if($type === 'masuk')
                <script>
                function openEditModalMasuk(id, barangId, jumlah, tanggal, keterangan) {
                    const form = document.getElementById('form-edit-barang-masuk');
                    form.action = '{{ route('barang_masuk.update', ':id') }}'.replace(':id', id);
                    document.getElementById('edit_id_masuk').value = id;
                    document.getElementById('edit_barang_masuk').value = barangId;
                    document.getElementById('edit_jumlah_masuk').value = jumlah;
                    document.getElementById('edit_tanggal_masuk').value = tanggal;
                    document.getElementById('edit_keterangan_masuk').value = keterangan || '';
                    openModal('modal-edit-barang-masuk');
                }
                </script>
                @else
                <script>
                function openEditModalKeluar(id, barangId, jumlah, tanggal, keterangan) {
                    const form = document.getElementById('form-edit-barang-keluar');
                    form.action = '{{ route('barang_keluar.update', ':id') }}'.replace(':id', id);
                    document.getElementById('edit_id_keluar').value = id;
                    document.getElementById('edit_barang_keluar').value = barangId;
                    document.getElementById('edit_jumlah_keluar').value = jumlah;
                    document.getElementById('edit_tanggal_keluar').value = tanggal;
                    document.getElementById('edit_keterangan_keluar').value = keterangan || '';
                    openModal('modal-edit-barang-keluar');
                }
                </script>
                @endif
            @endif
        </div>
    </div>
</div>