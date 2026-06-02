<!-- Modal Edit User -->
<div id="modal-user-edit" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Edit User</h3>
            <button onclick="closeModal('modal-user-edit')" class="modal-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form id="form-edit-user" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" name="nama" id="edit_name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_id_pegawai" class="form-label">Employee ID</label>
                        <input type="text" name="id_pegawai" id="edit_id_pegawai" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_role" class="form-label">Role</label>
                        <select name="role" id="edit_role" class="form-input" required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_password" class="form-label">Password (leave blank to keep current)</label>
                        <input type="password" name="password" id="edit_password" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="edit_password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="edit_password_confirmation" class="form-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-user-edit')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>