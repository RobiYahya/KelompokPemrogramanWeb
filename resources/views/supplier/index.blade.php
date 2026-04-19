@extends('layouts.app')

@section('title', 'Supplier - SIGURA')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Supplier</h1>
            <p class="card-subtitle">Kelola data supplier</p>
        </div>
        <div class="mt-4 sm:mt-0">
            @if(auth()->user()->role == 'admin')
            <button onclick="openModal('modal-supplier')" class="btn btn-primary">+ Tambah Supplier</button>
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
                        <th class="table-header-cell">Kontak</th>
                        <th class="table-header-cell">Telepon</th>
                        <th class="table-header-cell">Alamat</th>
                        <th class="table-header-cell">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($supplier as $index => $item)
                    <tr class="table-body-row">
                        <td class="table-cell-mono">{{ $item->formatted_id }}</td>
                        <td class="table-cell">{{ $item->nama }}</td>
                        <td class="table-cell-muted">{{ $item->kontak ?? '-' }}</td>
                        <td class="table-cell-muted">{{ $item->telepon ?? '-' }}</td>
                        <td class="table-cell-muted">{{ $item->alamat ?? '-' }}</td>
                        <td class="table-cell">
                            @if(auth()->user()->role == 'admin')
                            <div class="action-buttons">
                                <a href="{{ route('supplier.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('supplier.destroy', $item->id) }}" method="POST" class="contents" onsubmit="return confirm('Apakah Anda yakin?')">
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
                        <td colspan="6" class="empty-state">Belum ada data supplier</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@include('components.modal_supplier')
