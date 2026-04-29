@extends('layouts.app')

@section('title', 'Activity Logs - SIGURA')

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
                        <td class="table-cell">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td class="table-cell">{{ $log->user->name ?? 'Unknown' }}</td>
                        <td class="table-cell">
                            @if($log->action == 'create')
                                <span class="badge badge-green">Add</span>
                            @elseif($log->action == 'update')
                                <span class="badge badge-yellow">Edit</span>
                            @elseif($log->action == 'delete')
                                <span class="badge badge-red">Delete</span>
                            @elseif($log->action == 'barang_keluar')
                                <span class="badge badge-blue">Outgoing</span>
                            @elseif($log->action == 'barang_masuk')
                                <span class="badge badge-green">Incoming</span>
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