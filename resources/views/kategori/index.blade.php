@extends('layouts.app')

@section('title', 'Categories - SIGURA')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Categories</h1>
            <p class="card-subtitle">Manage category data</p>
        </div>
        <div class="mt-4 sm:mt-0">
            @if(auth()->user()->role == 'admin')
            <button onclick="openModal('modal-kategori')" class="btn btn-primary">+ Add Category</button>
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
                        <th class="table-header-cell">Category Name</th>
                        <th class="table-header-cell">Action</th>
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
                                <button onclick="openEditKategoriModal({{ $item->id }}, '{{ $item->nama }}')" class="btn btn-sm btn-primary">Edit</button>
                                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="contents" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                        <td colspan="3" class="empty-state">No category data yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $kategori->links() }}
    </div>
@endsection

@include('components.modal_kategori')
@include('components.modal_kategori_edit')