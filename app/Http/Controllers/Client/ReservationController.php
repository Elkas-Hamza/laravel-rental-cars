<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
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

        \Log::info('History page accessed: ' . $completedReservations->count() . ' reservations found');

        return view('client.reservations.history', compact('completedReservations'));
    }

    /**
     * Show the form for creating a new reservation
     */
    public function create(Car $car)
    {
        if (!session('date_de_location') || !session('date_de_retour')) {
            return redirect()->route('home')->with('error', 'Please select dates first');
        }

        $startDate = session('date_de_location');
        $endDate = session('date_de_retour');

        // Calculate the number of days
        $days = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);

        // Calculate the total price
        $totalPrice = $car->prix_journalier * $days;

        return view('client.reservations.create', compact('car', 'startDate', 'endDate', 'totalPrice', 'days'));
    }

    /**
     * Store a newly created reservation
     */
    public function store(Request $request, Car $car)
    {
        $validatedData = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'prix_total' => 'required|numeric|min:0',
        ]);

        $reservation = new Reservation($validatedData);
        $reservation->user_id = Auth::id();
        $reservation->car_id = $car->id;
        $reservation->status = 'pending';
        $reservation->save();

        return redirect()->route('client.reservations.index')->with('success', 'Reservation created successfully!');
    }

    /**
     * Cancel a reservation
     */
    public function cancel(Reservation $reservation)
    {
        // Make sure the user can only cancel their own reservations
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->route('client.reservations.index')->with('error', 'Unauthorized action');
        }

        $reservation->status = 'cancelled';
        $reservation->save();

        return redirect()->route('client.reservations.index')->with('success', 'Reservation cancelled successfully!');
    }
}
