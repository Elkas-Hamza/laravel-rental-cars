<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total cars count
        $totalCars = Car::count();

        // Get available cars count - modified to avoid using status column
        $availableCars = $totalCars; // Temporarily use total count

        // Get active reservations count
        $activeReservations = Reservation::where('status', 'active')->count();

        // Get total users count
        $totalUsers = User::where('is_admin', false)->count();

        // Get recent reservations
        $recentReservations = Reservation::with(['user', 'car'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get car categories with counts
        $carCategories = DB::table('cars')
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get()
            ->map(function($item) {
                return (object)[
                    'name' => $item->category,
                    'count' => $item->count
                ];
            });

        return view('admin.dashboard', compact(
            'totalCars',
            'availableCars',
            'activeReservations',
            'totalUsers',
            'recentReservations',
            'carCategories'
        ));
    }
}
