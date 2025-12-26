<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|string|unique:users,user_id',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'surname' => 'required|string',
            'password' => 'required|string|min:6',
            'user_role' => 'required|string',
            'user_department_id' => 'required|exists:departments,id',
            'is_active' => 'required|boolean',
        ]);

        $qr_token = null;

        if ($validated['user_role'] == 'student') {
            $qr_token = Str::random(32);  // dynamic qr code
        }


        


        User::create([
            'user_id' => $validated['user_id'],
            'email' => $validated['email'],
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'password' => Hash::make($validated['password']),
            'user_role' => $validated['user_role'],
            'user_department_id' => $validated['user_department_id'],
            'is_active' => $validated['is_active'],
            'qr_token' => $qr_token,
        ]);


        return redirect()->route('dashboard')->with('success', 'User added successfully');
    }

    public function index()
{
    $users = User::paginate(10); // paginate for better UX
    return view('users.index', compact('users'));
}

public function edit(User $user)
{
    $departments = Department::all();
    return view('users.edit', compact('user', 'departments'));
}

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'user_id' => 'required|unique:users,user_id,' . $user->id,
        'email' => 'required|email|unique:users,email,' . $user->id,
        'name' => 'required|string',
        'surname' => 'required|string',
        'user_role' => 'required|string|in:student,teacher,admin',
        'user_department_id' => 'required|exists:departments,id',
        'is_active' => 'required|boolean',
    ]);

    // If password is filled, update it
    if ($request->filled('password')) {
        $validated['password'] = Hash::make($request->password);
    } else {
        unset($validated['password']);
    }

    $user->update($validated);

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}

public function destroy(User $user)
{
    $user->delete();
    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
}

    public function studentviewQR()
    {
        $student = auth()->user(); // Giriş yapan öğrenci bilgileri

        // Eğer öğrenciye ait QR token yoksa, yeni bir token oluşturabiliriz (isteğe bağlı)
        if (!$student->qr_token) {

            return redirect()->route('dashboard')->with('success', 'No qr code');

        }

        return view('student.qrcode', compact('student'));
    }
}
