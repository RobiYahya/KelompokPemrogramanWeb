<!-- Modal User -->
<div id="modal-user" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Add User</h3>
            <button onclick="closeModal('modal-user')" class="modal-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="nama" id="name" class="form-input" placeholder="Enter name" required>
                        @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-input" placeholder="Enter email" required>
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_pegawai" class="form-label">Employee ID</label>
                        <input type="text" name="id_pegawai" id="id_pegawai" class="form-input" placeholder="Enter employee ID" required>
                        @error('id_pegawai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-input" required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                        </select>
                        @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-input" placeholder="Enter password" required>
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Confirm password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-user')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>