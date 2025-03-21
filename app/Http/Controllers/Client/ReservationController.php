<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
        // Validate the form data
        $validatedData = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'prix_total' => 'required|numeric|min:0',
            'pickup_location' => 'required|string',
            'return_location' => 'required|string',
            'pickup_fee' => 'required|numeric|min:0',
            'return_fee' => 'required|numeric|min:0',
            'accessories_fee' => 'required|numeric|min:0',
            'add_gps' => 'sometimes|boolean',
            'add_wifi' => 'sometimes|boolean',
            'add_baby_seat' => 'sometimes|boolean',
            'add_full_tank' => 'sometimes|boolean',
        ]);

        // Calculate rental days
        $startDate = new \DateTime($validatedData['date_debut']);
        $endDate = new \DateTime($validatedData['date_fin']);
        $interval = $startDate->diff($endDate);
        $days = $interval->days ?: 1; // Minimum 1 day

        // Create a new reservation
        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->car_id = $car->id;
        $reservation->date_debut = $validatedData['date_debut'];
        $reservation->date_fin = $validatedData['date_fin'];
        $reservation->prix_total = $validatedData['prix_total'];
        $reservation->pickup_location = $validatedData['pickup_location'];
        $reservation->return_location = $validatedData['return_location'];
        $reservation->pickup_fee = $validatedData['pickup_fee'];
        $reservation->return_fee = $validatedData['return_fee'];
        $reservation->add_gps = $request->has('add_gps');
        $reservation->add_wifi = $request->has('add_wifi');
        $reservation->add_baby_seat = $request->has('add_baby_seat');
        $reservation->add_full_tank = $request->has('add_full_tank');
        $reservation->accessories_fee = $validatedData['accessories_fee'];
        $reservation->status = 'pending';
        $reservation->save();

        // Redirect to payment page
        return redirect()->route('client.reservations.payment', $reservation)->with('success', 'Reservation created! Please complete payment.');
    }

    /**
     * Show payment page for a reservation
     */
    public function payment(Reservation $reservation)
    {
        // Make sure the user can only access their own reservations
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->route('client.reservations.index')->with('error', 'Unauthorized action');
        }

        // Load the car details to show on the payment page
        $reservation->load('car');
        
        // Calculate reservation dates and duration
        $startDate = new \DateTime($reservation->date_debut);
        $endDate = new \DateTime($reservation->date_fin);
        $interval = $startDate->diff($endDate);
        $days = $interval->days ?: 1; // Minimum 1 day
        
        return view('client.reservations.payment', compact('reservation', 'days'));
    }

    /**
     * Process payment for a reservation
     */
    public function processPayment(Request $request, Reservation $reservation)
    {
        // Make sure the user can only pay for their own reservations
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->route('client.reservations.index')->with('error', 'Unauthorized action');
        }
        
        // Validate payment details
        $request->validate([
            'card_number' => 'required|string',
            'card_holder' => 'required|string|max:255',
            'expiry_month' => 'required|string|size:2',
            'expiry_year' => 'required|string|size:2',
            'cvv' => 'required|string|size:3',
        ]);
        
        // Validate expiration date is in the future
        $expiryMonth = $request->input('expiry_month');
        $expiryYear = $request->input('expiry_year');
        $expiryDate = \Carbon\Carbon::createFromDate('20'.$expiryYear, $expiryMonth, 1)->endOfMonth();
        
        if ($expiryDate->isPast()) {
            return redirect()->back()->withErrors(['expiry_date' => 'The expiration date must be in the future.'])->withInput();
        }
        
        // In a real application, you would process the payment with a payment gateway here
        // For demo purposes, we'll just mark the reservation as confirmed
        
        $reservation->status = 'confirmed';
        $reservation->save();
        
        // Mark the car as unavailable for the reservation period
        $car = $reservation->car;
        $car->disponible = false;
        $car->save();
        
        return redirect()->route('client.reservations.index')->with('success', 'Payment processed successfully! Your reservation is confirmed.');
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
