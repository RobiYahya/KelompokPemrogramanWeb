<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'manager'])->orderBy('created_at', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:50',
            'email'      => 'required|string|email|max:50|unique:users,email',
            'id_pegawai' => 'required|string|max:50|unique:users,id_pegawai',
            'role'       => 'required|in:admin,manager',
            'password'   => 'required|string|min:8|confirmed',
        ]);
        User::create([
            'nama'       => $request->nama,
            'email'      => $request->email,
            'id_pegawai' => $request->id_pegawai,
            'role'       => $request->role,
            'password'   => Hash::make($request->password),
        ]);
        return redirect()->route('users.index')->with('success', 'User added successfully.');
    }

    public function update(Request $request, User $user)
    {
        if ($user->role === 'super_admin') {
            abort(403, 'Cannot edit Super Admin account');
        }

        $rules = [
            'nama'       => 'required|string|max:50',
            'email'      => 'required|string|email|max:50|unique:users,email,' . $user->id_user . ',id_user',
            'id_pegawai' => 'required|string|max:50|unique:users,id_pegawai,' . $user->id_user . ',id_user',
            'role'       => 'required|in:admin,manager',
        ];

        // Validate password together with other fields so update only runs if everything is valid
        if ($request->filled('password')) {
            $rules['password']              = 'required|string|min:8|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        $validated = $request->validate($rules);

        $data = [
            'nama'       => $validated['nama'],
            'email'      => $validated['email'],
            'id_pegawai' => $validated['id_pegawai'],
            'role'       => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'super_admin') {
            abort(403, 'Cannot delete Super Admin account');
        }
        if ($user->id_user === auth()->user()->id_user) {
            abort(403, 'Cannot delete your own account');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}