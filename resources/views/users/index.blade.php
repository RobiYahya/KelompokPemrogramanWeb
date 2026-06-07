@extends('layouts.app')

@section('title', 'User Management - MAGURA')

@section('content')
    <div class="card-header">
        <div>
            <h1 class="card-title">User Management</h1>
            <p class="card-subtitle">Manage Admin and Manager accounts</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button onclick="openModal('modal-user')" class="btn btn-primary">+ Add User</button>
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
                        <th class="table-header-cell">ID</th>
                        <th class="table-header-cell">Name</th>
                        <th class="table-header-cell">Email</th>
                        <th class="table-header-cell">Employee ID</th>
                        <th class="table-header-cell">Role</th>
                        <th class="table-header-cell">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr class="table-body-row">
                        <td class="table-cell-mono">{{ $user->id_user }}</td>
                        <td class="table-cell">{{ $user->nama }}</td>
                        <td class="table-cell-muted">{{ $user->email }}</td>
                        <td class="table-cell-muted">{{ $user->id_pegawai }}</td>
                        <td class="table-cell">
                            @if($user->role === 'admin')
                                <span class="badge badge-primary">Admin</span>
                            @elseif($user->role === 'manager')
                                <span class="badge badge-secondary">Manager</span>
                            @endif
                        </td>
                        <td class="table-cell">
                            <div class="action-buttons">
                                <button onclick="openEditUserModal(@json($user->id_user), @json($user->nama), @json($user->email), @json($user->id_pegawai), @json($user->role))" class="btn btn-sm btn-primary">Edit</button>
                                <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" class="contents" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">No user data yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endsection

@include('components.modal_user')
@include('components.modal_user_edit')

<script>
function openEditUserModal(id, name, email, idPegawai, role) {
    document.getElementById('form-edit-user').action = '{{ route('users.update', ':id') }}'.replace(':id', id);
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_id_pegawai').value = idPegawai;
    document.getElementById('edit_role').value = role;
    openModal('modal-user-edit');
}
</script>