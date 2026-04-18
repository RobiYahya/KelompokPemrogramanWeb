@extends('layouts.app')

@section('title', 'Kategori - SIGURA')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Data Kategori</h1>
            <p class="card-subtitle">Kelola data kategori</p>
        </div>
        <div class="mt-4 sm:mt-0">
            @if(auth()->user()->role == 'admin')
            <button onclick="openModal('modal-kategori')" class="btn btn-primary">+ Tambah Kategori</button>
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
                        <th class="table-header-cell">Nama Kategori</th>
                        <th class="table-header-cell">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $index => $item)
                    <tr class="table-body-row">
                        <td class="table-cell-mono">{{ $item->formatted_id }}</td>
                        <td class="table-cell">{{ $item->nama }}</td>
                        <td class="table-cell">
                            @if(auth()->user()->role == 'admin')
                            <div class="action-buttons">
                                <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                    Edit
                                </a>
                                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="contents" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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
                        <td colspan="3" class="empty-state">Belum ada data kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@include('components.modal_kategori')
