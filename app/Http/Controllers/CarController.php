<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of all cars with search and filter capabilities
     */
    public function index(Request $request)
    {
        $query = Car::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('marque', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%')
                  ->orWhere('year', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Apply filters if they exist
        if ($request->has('marque') && !empty($request->marque)) {
            $query->where('marque', $request->marque);
        }

        if ($request->has('model') && !empty($request->model)) {
            $query->where('model', $request->model);
        }

        if ($request->has('fuel_type') && !empty($request->fuel_type)) {
            $query->where('fuel_type', $request->fuel_type);
        }

        if ($request->has('price_min') && !empty($request->price_min)) {
            $query->where('prix_journalier', '>=', $request->price_min);
        }

        if ($request->has('price_max') && !empty($request->price_max)) {
            $query->where('prix_journalier', '<=', $request->price_max);
        }

        $cars = $query->latest()->get();
        
        // Handle AJAX requests
        if ($request->ajax()) {
            $carsData = $cars->map(function($car) {
                return [
                    'id' => $car->id,
                    'marque' => $car->marque,
                    'model' => $car->model,
                    'description' => $car->description,
                    'prix_journalier' => $car->prix_journalier,
                    'year' => $car->year,
                    'seats' => $car->seats,
                    'transmission' => $car->transmission,
                    'fuel_type' => $car->fuel_type,
                    'color' => $car->color,
                    'image' => $car->image,
                    'disponible' => $car->disponible,
                ];
            });
            
            return response()->json([
                'cars' => $carsData,
                'count' => $carsData->count()
            ]);
        }
        
        return view('cars.index', compact('cars'));
    }

    /**
     * Display a listing of available cars based on date range in session
     */
    public function available()
    {
        if (!session('date_de_location') || !session('date_de_retour')) {
            return redirect()->route('home')->with('error', 'Please select dates first');
        }

        $startDate = session('date_de_location');
        $endDate = session('date_de_retour');

        // Find cars that are not reserved in the given date range
        $reservedCarIds = Reservation::where(function ($query) use ($startDate, $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                // Reservation that overlaps with requested period
                $q->where('date_debut', '<=', $endDate)
                  ->where('date_fin', '>=', $startDate);
            })
            ->where('status', '!=', 'cancelled');
        })->pluck('car_id')->toArray();

        $cars = Car::where('disponible', true)
                   ->whereNotIn('id', $reservedCarIds)
                   ->paginate(12);

        return view('cars.available', compact('cars', 'startDate', 'endDate'));
    }

    /**
     * Display the specified car
     */
    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    /**
     * Filter cars by various criteria
     */
    public function filter(Request $request)
    {
        $query = Car::query();

        // Search by name, model, etc.
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('marque', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%')
                  ->orWhere('year', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter by brand
        if ($request->has('marque') && !empty($request->marque)) {
            $query->where('marque', $request->marque);
        }

        // Filter by model
        if ($request->has('model') && !empty($request->model)) {
            $query->where('model', $request->model);
        }

        // Filter by fuel type
        if ($request->has('fuel_type') && !empty($request->fuel_type)) {
            $query->where('fuel_type', $request->fuel_type);
        }

        // Filter by price range
        if ($request->has('price_min') && !empty($request->price_min)) {
            $query->where('prix_journalier', '>=', $request->price_min);
        }

        if ($request->has('price_max') && !empty($request->price_max)) {
            $query->where('prix_journalier', '<=', $request->price_max);
        }

        // Get cars
        $cars = $query->latest()->get();

        // Prepare data for response
        $carsData = $cars->map(function($car) {
            return [
                'id' => $car->id,
                'marque' => $car->marque,
                'model' => $car->model,
                'description' => $car->description,
                'prix_journalier' => $car->prix_journalier,
                'year' => $car->year,
                'seats' => $car->seats,
                'transmission' => $car->transmission,
                'fuel_type' => $car->fuel_type,
                'color' => $car->color,
                'image' => $car->image,
                'disponible' => $car->disponible,
            ];
        });

        if ($request->ajax()) {
            return response()->json([
                'cars' => $carsData,
                'count' => $carsData->count()
            ]);
        }

        return view('cars.filter', compact('cars'));
    }

    /**
     * Show the form for creating a new car.
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created car in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'seats' => 'required|integer|min:1|max:12',
            'transmission' => 'required|string|in:automatic,manual',
            'fuel_type' => 'required|string|in:gasoline,diesel,electric,hybrid',
            'license_plate' => 'required|string|max:20|unique:cars',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|in:available,rented,maintenance',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            $validated['image_url'] = 'storage/' . $imagePath;
        }

        Car::create($validated);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car created successfully.');
    }

    /**
     * Show the form for editing the specified car.
     */
    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update the specified car in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'seats' => 'required|integer|min:1|max:12',
            'transmission' => 'required|string|in:automatic,manual',
            'fuel_type' => 'required|string|in:gasoline,diesel,electric,hybrid',
            'license_plate' => 'required|string|max:20|unique:cars,license_plate,' . $car->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|in:available,rented,maintenance',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($car->image_url && Storage::disk('public')->exists(str_replace('storage/', '', $car->image_url))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $car->image_url));
            }

            $imagePath = $request->file('image')->store('cars', 'public');
            $validated['image_url'] = 'storage/' . $imagePath;
        }

        $car->update($validated);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car updated successfully.');
    }

    /**
     * Remove the specified car from storage.
     */
    public function destroy(Car $car)
    {
        // Delete car image if exists
        if ($car->image_url && Storage::disk('public')->exists(str_replace('storage/', '', $car->image_url))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $car->image_url));
        }

        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car deleted successfully.');
    }

    /**
     * Store car ID in session before redirecting to login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCarSession(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id'
        ]);
        
        // Store car ID in session
        $request->session()->put('car_id', $request->car_id);
        
        // Redirect to login page
        return redirect()->route('login');
    }
}
