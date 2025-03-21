<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter users based on admin status
        if ($request->has('type')) {
            if ($request->type === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->type === 'client') {
                $query->where('is_admin', false);
            }
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('name')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Get user reservations
        $reservations = Reservation::where('user_id', $user->id)
            ->with('car')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get reservation statistics
        $activeReservations = $reservations->where('status', 'active')->count();
        $completedReservations = $reservations->where('status', 'completed')->count();
        $cancelledReservations = $reservations->where('status', 'cancelled')->count();
        $totalSpent = $reservations->where('status', '!=', 'cancelled')->sum('total_price');

        return view('admin.users.show', compact(
            'user',
            'reservations',
            'activeReservations',
            'completedReservations',
            'cancelledReservations',
            'totalSpent'
        ));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'is_admin' => 'boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Only update password if provided
        if (empty($validatedData['password'])) {
            unset($validatedData['password']);
        } else {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User information updated successfully');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Check if user has active reservations
        $activeReservationsCount = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['active', 'pending'])
            ->count();

        if ($activeReservationsCount > 0) {
            return back()->with('error', 'Cannot delete user with active or pending reservations.');
        }

        // Delete user
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}
