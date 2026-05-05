@extends('layouts.app')

@section('title', 'Incoming Items - Magura')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Incoming Items</h1>
            <p class="card-subtitle">Incoming items history</p>
        </div>
        <div class="mt-4 sm:mt-0">
            @if(auth()->user()->role == 'admin')
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
                        <th class="table-header-cell">Item ID</th>
                        <th class="table-header-cell">Item</th>
                        <th class="table-header-cell">Quantity</th>
                        <th class="table-header-cell">Date</th>
                        <th class="table-header-cell">Description</th>
                        <th class="table-header-cell">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangMasuk as $index => $item)
                    <tr class="table-body-row">
                        <td class="table-cell-mono">{{ $item->barang->formatted_id ?? '-' }}</td>
                        <td class="table-cell">{{ $item->barang->nama ?? '-' }}</td>
                        <td class="table-cell">{{ $item->jumlah }}</td>
                        <td class="table-cell-muted">{{ $item->tanggal }}</td>
                        <td class="table-cell-muted">{{ $item->keterangan ?? '-' }}</td>
                        <td class="table-cell">
                            @if(auth()->user()->role == 'admin')
                            <div class="action-buttons">
                                <button onclick="openEditModalMasuk({{ $item->id }}, {{ $item->barang_id }}, {{ $item->jumlah }}, '{{ $item->tanggal }}', '{{ addslashes($item->keterangan ?? '') }}')" class="btn btn-sm btn-primary">Edit</button>
                                <form action="{{ route('barang_masuk.destroy', $item->id) }}" method="POST" class="contents" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="6" class="empty-state">No incoming items data yet</td>
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
@endsection

@include('components.modal_barang_masuk', ['barang' => $barang])
@include('components.modal_edit_barang_masuk', ['barang' => $barang])