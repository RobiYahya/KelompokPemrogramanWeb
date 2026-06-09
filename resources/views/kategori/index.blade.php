@extends('layouts.app')

@section('title', 'Categories - Magura')

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Categories</h1>
            <p class="card-subtitle">Manage category data</p>
        </div>
        <div class="mt-4 sm:mt-0">
            @if(auth()->user()->role === 'admin')
            <button onclick="openModal('modal-kategori')" class="btn btn-primary">+ Add Category</button>
            @endif
        </div>
    </div>

    @if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
    @endif

    @if(session('error_pop'))
    <div id="modal-error-pop" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm transition-all duration-300">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform scale-100 transition-all border border-red-100">
            <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-red-50 text-red-500 rounded-full shrink-0">
                        <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Category Already Exists</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ session('error_pop') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button onclick="document.getElementById('modal-error-pop').remove()" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 active:scale-95 transition-all text-white font-semibold text-sm rounded-xl shadow-md hover:shadow-lg">
                    I Understand
                </button>
            </div>
        </div>
    </div>
    @endif

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
                        <th class="table-header-cell">Category ID</th>
                        <th class="table-header-cell">Category Name</th>
                        <th class="table-header-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $index => $item)
                    <tr class="table-body-row">
                        <td class="table-cell-mono">{{ $item->formatted_id }}</td>
                        <td class="table-cell">{{ $item->nama_kategori }}</td>
                        <td class="table-cell">
                            @if(auth()->user()->role === 'admin')
                            <div class="action-buttons">
                                <button onclick="openEditKategoriModal({{ json_encode($item->id_kategori) }}, {{ json_encode($item->nama_kategori) }})" class="btn btn-sm btn-primary">Edit</button>
                                <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST" class="contents" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
    @include('components.modal_kategori')
    @include('components.modal_kategori_edit')
@endsection