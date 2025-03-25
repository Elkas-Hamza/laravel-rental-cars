<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the reservations.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'car']);

        // Filter by status if provided
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter by user if provided
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by car if provided
        if ($request->has('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        // Search by reservation ID or user name
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('model', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('car', function($q) use ($search) {
                      $q->where('model', 'like', "%{$search}%")
                        ->orWhere('license_plate', 'like', "%{$search}%");
                  });
            });
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get users and cars for filter dropdowns
        $users = User::where('is_admin', false)->orderBy('name')->get();
        $cars = Car::orderBy('model')->get();
        $statuses = ['all', 'pending', 'active', 'completed', 'cancelled'];

        return view('admin.reservations.index', compact('reservations', 'users', 'cars', 'statuses'));
    }

    /**
     * Display the specified reservation.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'car']);
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit(Reservation $reservation)
    {
        $reservation->load(['user', 'car']);
        $users = User::where('is_admin', false)->orderBy('name')->get();
        $cars = Car::where('status', 'available')->orWhere('id', $reservation->car_id)->orderBy('model')->get();
        $statuses = ['pending', 'active', 'completed', 'cancelled'];

        return view('admin.reservations.edit', compact('reservation', 'users', 'cars', 'statuses'));
    }

    /**
     * Update the specified reservation in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,active,completed,cancelled',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        // If car is changed, update the status of both old and new cars
        if ($reservation->car_id != $validatedData['car_id']) {
            // Make the old car available
            $oldCar = Car::find($reservation->car_id);
            if ($oldCar && $oldCar->status == 'rented') {
                $oldCar->update(['status' => 'available']);
            }

            // Make the new car rented if reservation is active
            if ($validatedData['status'] == 'active') {
                $newCar = Car::find($validatedData['car_id']);
                if ($newCar && $newCar->status == 'available') {
                    $newCar->update(['status' => 'rented']);
                }
            }
        }
        // If only status is changed
        elseif ($reservation->status != $validatedData['status']) {
            $car = Car::find($reservation->car_id);

            if ($car) {
                if ($validatedData['status'] == 'active') {
                    $car->update(['status' => 'rented']);
                } elseif (in_array($validatedData['status'], ['completed', 'cancelled']) && $car->status == 'rented') {
                    $car->update(['status' => 'available']);
                }
            }
        }

        $reservation->update($validatedData);

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservation updated successfully');
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy(Reservation $reservation)
    {
        // If reservation is active, make the car available first
        if ($reservation->status == 'active') {
            $car = Car::find($reservation->car_id);
            if ($car && $car->status == 'rented') {
                $car->update(['status' => 'available']);
            }
        }

        $reservation->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservation deleted successfully');
    }
}
