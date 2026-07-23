<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index()
    {
        $search = request('search');
        $role = request('role');
        $sortBy = request('sort_by', 'latest');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('username', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        if ($sortBy === 'oldest') {
            $query->oldest();
        } elseif ($sortBy === 'name_asc') {
            $query->orderBy('name', 'asc');
        } elseif ($sortBy === 'name_desc') {
            $query->orderBy('name', 'desc');
        } else {
            $query->latest();
        }

        $users = $query->paginate(10)->appends(request()->query());

        return view('admin.users.index', compact('users', 'search', 'role', 'sortBy'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:customer,merchant,admin',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan oleh akun lain.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'role.required' => 'Peran (role) wajib dipilih.',
            'avatar.image' => 'Berkas harus berupa gambar.',
            'avatar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data['password'] = bcrypt($data['password']);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $data['avatar_path'] = $path;
        }

        $newUser = User::create($data);

        ActivityLog::log("Admin " . auth()->user()->name . " membuat akun " . $newUser->role . " baru: " . $newUser->name . " (@" . $newUser->username . ")");

        return redirect()->route('admin.users.index')->with('success', 'Akun user baru berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'role' => 'required|string|in:customer,merchant,admin',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if (!$user->google_id) {
            $rules['email'] = [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ];
        }

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8';
        }

        $data = $request->validate($rules);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('avatar')) {

            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $data['avatar_path'] = $path;
        }

        $user->update($data);

        ActivityLog::log("Admin " . auth()->user()->name . " mengedit akun " . $user->role . ": " . $user->name . " (@" . $user->username . ")");

        return redirect()->route('admin.users.index')->with('success', 'Rincian data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $role = $user->role;
        $name = $user->name;
        $username = $user->username;

        $user->delete();

        ActivityLog::log("Admin " . auth()->user()->name . " menghapus akun " . $role . ": " . $name . " (@" . $username . ")");

        return redirect()->route('admin.users.index')->with('success', 'Akun user berhasil dihapus secara permanen.');
    }
}
