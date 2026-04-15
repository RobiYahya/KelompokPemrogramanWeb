@extends('layouts.app')

@section('title', 'Dashboard - SIGURA')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">Dashboard</h1>
            <p class="card-subtitle">Selamat datang, {{ auth()->user()->name }} ({{ auth()->user()->role === 'admin' ? 'Admin' : 'Manajer' }})</p>
        </div>
    </div>

    @if(auth()->user()->role === 'manager')
    <div class="alert alert-warning">
        <strong>Mode View-Only:</strong> Sebagai Manajer, Anda hanya dapat melihat data tanpa dapat melakukan perubahan.
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Barang Masuk Hari Ini -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Barang Masuk Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $barangMasukHariIni }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Barang Keluar Hari Ini -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Barang Keluar Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $barangKeluarHariIni }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Stok -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Stok</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalStok }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Kategori -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Kategori</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalKategori }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Supplier Card -->
    <div class="card mb-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Supplier</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalSupplier }}</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Barang Stok Minimum Table -->
    <div class="card">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Barang Stok Minimum</h2>
        <div class="overflow-x-auto">
            <table class="table">
                <thead class="table-header">
                    <tr>
                        <th class="table-header-cell">ID Barang</th>
                        <th class="table-header-cell">Nama Barang</th>
                        <th class="table-header-cell">Kategori</th>
                        <th class="table-header-cell">Supplier</th>
                        <th class="table-header-cell">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangLowStock as $barang)
                    <tr class="table-body-row">
                        <td class="table-cell-mono">{{ $barang->formatted_id }}</td>
                        <td class="table-cell">{{ $barang->nama }}</td>
                        <td class="table-cell-muted">{{ $barang->kategori->formatted_id ?? '-' }}</td>
                        <td class="table-cell-muted">{{ $barang->supplier->formatted_id ?? '-' }}</td>
                        <td class="table-cell">
                            <span class="badge badge-red">{{ $barang->stok }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">Tidak ada barang dengan stok minimum</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
