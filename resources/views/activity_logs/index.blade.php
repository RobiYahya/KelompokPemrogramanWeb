@extends('layouts.app')

@section('title', 'Riwayat Aktivitas - SIGURA')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Riwayat Aktivitas</h1>
            <p class="card-subtitle">Melihat aktivitas admin</p>
        </div>
    </div>

    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="table">
                <thead class="table-header">
                    <tr>
                        <th class="table-header-cell">Waktu</th>
                        <th class="table-header-cell">User</th>
                        <th class="table-header-cell">Aksi</th>
                        <th class="table-header-cell">Nama Barang</th>
                        <th class="table-header-cell">ID Kategori</th>
                        <th class="table-header-cell">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activityLogs as $log)
                    <tr class="table-body-row">
                        <td class="table-cell">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td class="table-cell">{{ $log->user->name ?? 'Unknown' }}</td>
                        <td class="table-cell">
                            @if($log->action == 'create')
                                <span class="badge badge-green">Tambah</span>
                            @elseif($log->action == 'update')
                                <span class="badge badge-yellow">Edit</span>
                            @elseif($log->action == 'delete')
                                <span class="badge badge-red">Hapus</span>
                            @elseif($log->action == 'barang_keluar')
                                <span class="badge badge-blue">Keluar</span>
                            @elseif($log->action == 'barang_masuk')
                                <span class="badge badge-green">Masuk</span>
                            @endif
                        </td>
                        <td class="table-cell">
                            @if($log->model == 'Barang Masuk' && $log->model_id)
                                {{ \App\Models\BarangMasuk::find($log->model_id)?->barang->nama ?? '-' }}
                            @elseif($log->model == 'Barang Keluar' && $log->model_id)
                                {{ \App\Models\BarangKeluar::find($log->model_id)?->barang->nama ?? '-' }}
                            @else
                                {{ $log->model }}
                            @endif
                        </td>
                        <td class="table-cell">
                            @if($log->model == 'Barang Masuk' && $log->model_id)
                                {{ \App\Models\BarangMasuk::find($log->model_id)?->barang->kategori->formatted_id ?? '-' }}
                            @elseif($log->model == 'Barang Keluar' && $log->model_id)
                                {{ \App\Models\BarangKeluar::find($log->model_id)?->barang->kategori->formatted_id ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="table-cell">{{ $log->description }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">Belum ada data aktivitas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
