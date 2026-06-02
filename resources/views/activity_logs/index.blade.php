@extends('layouts.app')

@section('title', 'Activity Logs - Magura')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Activity Logs</h1>
            <p class="card-subtitle">View admin activities</p>
        </div>
    </div>

    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="table">
                <thead class="table-header">
                    <tr>
                        <th class="table-header-cell">Time</th>
                        <th class="table-header-cell">User</th>
                        <th class="table-header-cell">Action</th>
                        <th class="table-header-cell">Item Name</th>
                        <th class="table-header-cell">Category ID</th>
                        <th class="table-header-cell">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activityLogs as $log)
                    <tr class="table-body-row">
                        <td class="table-cell">{{ $log->tanggal ? \Carbon\Carbon::parse($log->tanggal)->format('d/m/Y H:i') : '-' }}</td>
                        <td class="table-cell">{{ $log->user->nama ?? 'Unknown' }}</td>
                        <td class="table-cell">
                            @if($log->aksi == 'create')
                                <span class="badge badge-green">Add</span>
                            @elseif($log->aksi == 'update')
                                <span class="badge badge-yellow">Edit</span>
                            @elseif($log->aksi == 'delete')
                                <span class="badge badge-red">Delete</span>
                            @elseif($log->aksi == 'barang_keluar')
                                <span class="badge badge-blue">Outgoing</span>
                            @elseif($log->aksi == 'barang_masuk')
                                <span class="badge badge-green">Incoming</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($log->aksi) }}</span>
                            @endif
                        </td>
                        <td class="table-cell">{{ $log->nama_barang ?? '-' }}</td>
                        <td class="table-cell">{{ $log->kategori ? $log->kategori->formatted_id : ($log->id_kategori ?? '-') }}</td>
                        <td class="table-cell">{{ $log->deskripsi }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">No activity data yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $activityLogs->links() }}
    </div>
@endsection
    