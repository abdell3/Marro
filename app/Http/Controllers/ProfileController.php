<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth');
    }

    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        
        $this->userService->updateUser($user->id, $data);
        
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the form for changing the user's password.
     */
    public function editPassword()
    {
        return view('profile.password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('profile.show')->with('success', 'Password changed successfully.');
    }

    /**
     * Show the form for deleting the user's account.
     */
    public function confirmDelete()
    {
        return view('profile.delete');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The password is incorrect.']);
        }
        
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        
        $this->userService->deleteUser($user->id);
        
        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}
