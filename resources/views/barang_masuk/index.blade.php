@extends('layouts.app')

@section('title', 'Barang Masuk - SIGURA')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Barang Masuk</h1>
            <p class="card-subtitle">Riwayat barang masuk</p>
        </div>
        <div class="mt-4 sm:mt-0">
            @if(auth()->user()->role == 'admin')
            <button onclick="openModal('modal-barang-masuk')" class="btn btn-primary">+ Barang Masuk</button>
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
                        <th class="table-header-cell">ID Barang</th>
                        <th class="table-header-cell">Barang</th>
                        <th class="table-header-cell">Jumlah</th>
                        <th class="table-header-cell">Tanggal</th>
                        <th class="table-header-cell">Keterangan</th>
                        <th class="table-header-cell">Aksi</th>
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
                            <form action="{{ route('barang_masuk.destroy', $item->id) }}" method="POST" class="contents" onsubmit="return confirm('Apakah Anda yakin?')">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">Belum ada data barang masuk</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@include('components.modal_barang_masuk', ['barang' => $barang])
