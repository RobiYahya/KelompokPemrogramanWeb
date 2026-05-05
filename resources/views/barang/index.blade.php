@extends('layouts.app')

@section('title', 'Items - Magura')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Items</h1>
            <p class="card-subtitle">Manage item data</p>
        </div>
        <div class="mt-4 sm:mt-0">
            @if(auth()->user()->role == 'admin')
            <button onclick="openModal('modal-barang')" class="btn btn-primary">+ Add Item</button>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="table">
                <thead class="table-header">
                    <tr>
                        <th class="table-header-cell">ID</th>
                        <th class="table-header-cell">Name</th>
                        <th class="table-header-cell">Category</th>
                        <th class="table-header-cell">Supplier</th>
                        <th class="table-header-cell">Stock</th>
                        <th class="table-header-cell">Min Stock</th>
                        <th class="table-header-cell">Purchase Price</th>
                        <th class="table-header-cell">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $index => $item)
                    <tr class="table-body-row">
                        <td class="table-cell-mono">{{ $item->formatted_id }}</td>
                        <td class="table-cell">{{ $item->nama }}</td>
                        <td class="table-cell-muted">{{ $item->kategori->formatted_id ?? '-' }}</td>
                        <td class="table-cell-muted">{{ $item->supplier->formatted_id ?? '-' }}</td>
                        <td class="table-cell">{{ $item->stok }}</td>
                        <td class="table-cell-muted">{{ $item->minimum_stok }}</td>
                        <td class="table-cell-muted">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                        <td class="table-cell">
                            @if(auth()->user()->role == 'admin')
                            <div class="action-buttons">
                                <button onclick="openEditBarangModal({{ $item->id }}, '{{ $item->nama }}', {{ $item->kategori_id }}, {{ $item->supplier_id }}, {{ $item->stok }}, {{ $item->minimum_stok }}, {{ $item->harga_beli }})" class="btn btn-sm btn-primary">Edit</button>
                                <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="contents" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="8" class="empty-state">No item data yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $barang->links() }}
    </div>
@endsection

@include('components.modal_barang', ['kategori' => $kategori, 'supplier' => $supplier])
@include('components.modal_barang_edit', ['kategori' => $kategori, 'supplier' => $supplier])