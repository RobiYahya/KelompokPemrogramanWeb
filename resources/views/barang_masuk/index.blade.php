@extends('layouts.app')

@section('title', 'Incoming Items - Magura')

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Incoming Items</h1>
            <p class="card-subtitle">Incoming items history</p>
        </div>
        <div class="mt-4 sm:mt-0">
            @if(auth()->user()->role === 'admin')
            <button onclick="openModal('modal-barang-masuk')" class="btn btn-primary">+ Incoming</button>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
    @endif

    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="table">
                <thead class="table-header">
                    <tr>
                        <th class="table-header-cell">Transaction ID</th>
                        <th class="table-header-cell">Item ID</th>
                        <th class="table-header-cell">Item</th>
                        <th class="table-header-cell">Quantity</th>
                        <th class="table-header-cell">Date</th>
                        <th class="table-header-cell">Description</th>
                        <th class="table-header-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangMasuk as $index => $item)
                    <tr class="table-body-row">
                        <td class="table-cell-mono">{{ $item->formatted_id }}</td>
                        <td class="table-cell-mono">{{ $item->barang->formatted_id ?? '-' }}</td>
                        <td class="table-cell">{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td class="table-cell">{{ $item->jumlah }}</td>
                        <td class="table-cell-muted">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-' }}</td>
                        <td class="table-cell-muted">{{ $item->deskripsi ?? '-' }}</td>
                        <td class="table-cell">
                            @if(auth()->user()->role === 'admin')
                            <div class="action-buttons">
                                <button onclick="openEditModalMasuk({{ json_encode($item->id_masuk) }}, {{ json_encode($item->id_barang) }}, {{ json_encode($item->jumlah) }}, {{ json_encode($item->tanggal) }}, {{ json_encode($item->deskripsi) }})" class="btn btn-sm btn-primary">Edit</button>
                                <form action="{{ route('barang_masuk.destroy', $item->id_masuk) }}" method="POST" class="contents" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">No incoming items data yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $barangMasuk->links() }}
    </div>
    <x-stock-transaction-modal type="masuk" mode="create" :barang="$barang" />
    <x-stock-transaction-modal type="masuk" mode="edit" :barang="$barang" />
@endsection