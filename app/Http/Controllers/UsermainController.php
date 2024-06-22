<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermain;

class UsermainController extends Controller
{
    public function index()
    {
        // Fetch all users from the Usermain model
        $users = Usermain::all();

        // Pass the users data to the manageuser view
        return view('manageuser', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_first_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users',
            'user_password' => 'required|string|min:8',
            // รายการตัวแปรที่ต้องการตรวจสอบและบันทึก
        ]);

        $user = Usermain::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = Usermain::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_first_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email,' . $id,
            'user_password' => 'nullable|string|min:8',
            // รายการตัวแปรที่ต้องการตรวจสอบและอัปเดต
        ]);

        $user = Usermain::findOrFail($id);
        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = Usermain::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
