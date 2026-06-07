@extends('layouts.app')

@section('title', 'Suppliers - Magura')

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Suppliers</h1>
            <p class="card-subtitle">Manage supplier data</p>
        </div>
        <div class="mt-4 sm:mt-0">
            @if(auth()->user()->role === 'admin')
            <button onclick="openModal('modal-supplier')" class="btn btn-primary">+ Add Supplier</button>
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
                        <th class="table-header-cell">Supplier ID</th>
                        <th class="table-header-cell">Supplier Name</th>
                        <th class="table-header-cell">Contact Person</th>
                        <th class="table-header-cell">Phone Number</th>
                        <th class="table-header-cell">Address</th>
                        <th class="table-header-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($supplier as $index => $item)
                    <tr class="table-body-row">
                        <td class="table-cell-mono">{{ $item->formatted_id }}</td>
                        <td class="table-cell">{{ $item->nama_supplier }}</td>
                        <td class="table-cell-muted">{{ $item->kontak ?? '-' }}</td>
                        <td class="table-cell-muted">{{ $item->no_telp ?? '-' }}</td>
                        <td class="table-cell-muted">{{ $item->alamat ?? '-' }}</td>
                        <td class="table-cell">
                            @if(auth()->user()->role === 'admin')
                            <div class="action-buttons">
                                <button onclick="openEditSupplierModal(@json($item->id_supplier), @json($item->nama_supplier), @json($item->kontak), @json($item->no_telp), @json($item->alamat))" class="btn btn-sm btn-primary">Edit</button>
                                <form action="{{ route('supplier.destroy', $item->id_supplier) }}" method="POST" class="contents" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="6" class="empty-state">No supplier data yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $supplier->links() }}
    </div>
@endsection

@include('components.modal_supplier')
@include('components.modal_supplier_edit')