@extends('layouts.app')

@section('title', 'Data Barang - SIGURA')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Data Barang</h1>
            <p class="card-subtitle">Kelola data barang</p>
        </div>
        <div class="mt-4 sm:mt-0">
            @if(auth()->user()->role == 'admin')
            <button onclick="openModal('modal-barang')" class="btn btn-primary">+ Tambah Barang</button>
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
                        <th class="table-header-cell">Nama</th>
                        <th class="table-header-cell">Kategori</th>
                        <th class="table-header-cell">Supplier</th>
                        <th class="table-header-cell">Stok</th>
                        <th class="table-header-cell">Min Stok</th>
                        <th class="table-header-cell">Harga Beli</th>
                        <th class="table-header-cell">Aksi</th>
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
                                <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="contents" onsubmit="return confirm('Apakah Anda yakin?')">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">Belum ada data barang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@include('components.modal_barang', ['kategori' => $kategori, 'supplier' => $supplier])
