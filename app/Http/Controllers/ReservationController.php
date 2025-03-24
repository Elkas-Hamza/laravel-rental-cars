<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

class ReservationController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's reservations
     */
    public function index()
    {
        $allReservations = Auth::user()->reservations()->with('car')->latest()->get();

        $now = now();

        // Active reservations - started but not ended, confirmed
        $activeReservations = $allReservations->filter(function($res) use ($now) {
            return $res->status == 'confirmed' &&
                   strtotime($res->date_debut) <= strtotime($now) &&
                   strtotime($res->date_fin) >= strtotime($now);
        });

        // Upcoming reservations - not started yet, confirmed
        $upcomingReservations = $allReservations->filter(function($res) use ($now) {
            return ($res->status == 'confirmed' || $res->status == 'pending') &&
                   strtotime($res->date_debut) > strtotime($now);
        });

        // Completed reservations - ended or marked completed
        $completedReservations = $allReservations->filter(function($res) use ($now) {
            return $res->status == 'completed' ||
                   ($res->status == 'confirmed' && strtotime($res->date_fin) < strtotime($now));
        });

        // Cancelled reservations
        $cancelledReservations = $allReservations->filter(function($res) {
            return $res->status == 'cancelled';
        });

        return view('client.reservations.index', compact(
            'allReservations',
            'activeReservations',
            'upcomingReservations',
            'completedReservations',
            'cancelledReservations'
        ));
    }

    /**
     * Display a listing of the user's past reservations
     */
    public function history()
    {
        $completedReservations = Auth::user()->reservations()
            ->with('car')
            ->where(function($query) {
                $query->where('status', 'completed')
                      ->orWhere('status', 'cancelled')
                      ->orWhere(function($q) {
                          $q->where('status', 'confirmed')
                            ->where('date_fin', '<', now());
                      });
            })
            ->latest()
            ->get();

        // If no completed reservations, let's make sure we have an empty collection rather than null
        if (!$completedReservations) {
            $completedReservations = collect();
        }

        \Log::info('History page: ' . $completedReservations->count() . ' reservations found');

        return view('client.reservations.history', compact('completedReservations'));
    }

    /**
     * Show the form for creating a new reservation
     */
    public function create(Car $car)
    {
        $startDate = session('date_de_location', now()->format('Y-m-d'));
        $endDate = session('date_de_retour', now()->addDay()->format('Y-m-d'));

        // Calculate number of days
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = $end->diffInDays($start);
        $days = $days > 0 ? $days : 1; // At least 1 day

        // Calculate total price
        $totalPrice = $car->price_per_day * $days;

        return view('client.reservations.create', compact('car', 'startDate', 'endDate', 'days', 'totalPrice'));
    }

    /**
     * Store a newly created reservation
     */
    public function store(Request $request, Car $car)
    {
        $validated = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'pickup_location' => 'nullable|string|max:255',
            'return_location' => 'nullable|string|max:255',
        ]);

        $start = Carbon::parse($validated['date_debut']);
        $end = Carbon::parse($validated['date_fin']);
        $days = $end->diffInDays($start);
        $days = $days > 0 ? $days : 1; // At least 1 day

        // Calculate total price
        $totalPrice = $car->price_per_day * $days;

        // Add pickup/return fees if applicable
        if ($request->filled('pickup_location')) {
            $totalPrice += 25.00; // Example pickup fee
        }

        if ($request->filled('return_location')) {
            $totalPrice += 25.00; // Example return fee
        }

        $reservation = new Reservation();
        $reservation->user_id = auth()->id();
        $reservation->car_id = $car->id;
        $reservation->date_debut = $validated['date_debut'];
        $reservation->date_fin = $validated['date_fin'];
        $reservation->pickup_location = $validated['pickup_location'] ?? null;
        $reservation->return_location = $validated['return_location'] ?? null;
        $reservation->pickup_fee = $request->filled('pickup_location') ? 25.00 : 0;
        $reservation->return_fee = $request->filled('return_location') ? 25.00 : 0;
        $reservation->prix_total = $totalPrice;
        $reservation->status = 'pending';
        $reservation->save();

        // Mark car as unavailable
        // $car->disponible = false;
        // $car->save();

        return redirect()->route('client.reservations.show', $reservation)
            ->with('success', 'Your reservation has been created successfully!');
    }

    /**
     * Cancel a reservation
     */
    public function cancel(Reservation $reservation)
    {
        // Make sure the user can only cancel their own reservations
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->route('reservations.index')->with('error', 'Unauthorized action');
        }

        $reservation->status = 'cancelled';
        $reservation->save();

        return redirect()->route('reservations.index')->with('success', 'Reservation cancelled successfully!');
    }
}
