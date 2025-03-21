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
     * Display a listing of all cars
     */
    public function index()
    {
        $cars = Car::latest()->paginate(12);
        return view('admin.cars.index', compact('cars'));
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
        return view('admin.cars.show', compact('car'));
    }

    /**
     * Filter cars by various criteria
     */
    public function filter(Request $request)
    {
        \Log::info('Filter request received:', $request->all());

        $query = Car::query();

        // Search by name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
            \Log::info('Filtering by search:', ['term' => $request->search]);
        }

        // Filter by category
        if ($request->has('categories')) {
            \Log::info('Categories data:', ['categories' => $request->categories, 'type' => gettype($request->categories)]);
            if (is_array($request->categories) && count($request->categories) > 0) {
                $query->whereIn('category', $request->categories);
                \Log::info('Filtering by categories:', ['categories' => $request->categories]);
            }
        }

        // Filter by transmission
        if ($request->has('transmissions')) {
            \Log::info('Transmissions data:', ['transmissions' => $request->transmissions, 'type' => gettype($request->transmissions)]);
            if (is_array($request->transmissions) && count($request->transmissions) > 0) {
                $query->whereIn('transmission', $request->transmissions);
                \Log::info('Filtering by transmissions:', ['transmissions' => $request->transmissions]);
            }
        }

        // Filter by fuel type
        if ($request->has('fuel_types')) {
            \Log::info('Fuel types data:', ['fuel_types' => $request->fuel_types, 'type' => gettype($request->fuel_types)]);
            if (is_array($request->fuel_types) && count($request->fuel_types) > 0) {
                $query->whereIn('fuel_type', $request->fuel_types);
                \Log::info('Filtering by fuel types:', ['fuel_types' => $request->fuel_types]);
            }
        }

        // Filter by price range
        if ($request->has('price_min') && !empty($request->price_min)) {
            $query->where('price_per_day', '>=', $request->price_min);
            \Log::info('Filtering by min price:', ['price_min' => $request->price_min]);
        }

        if ($request->has('price_max') && !empty($request->price_max)) {
            $query->where('price_per_day', '<=', $request->price_max);
            \Log::info('Filtering by max price:', ['price_max' => $request->price_max]);
        }

        // Filter by seats
        if ($request->has('seats') && !empty($request->seats)) {
            $query->where('seats', '>=', $request->seats);
            \Log::info('Filtering by seats:', ['seats' => $request->seats]);
        }

        // Sort results
        if ($request->has('sort') && !empty($request->sort)) {
            \Log::info('Sorting by:', ['sort' => $request->sort]);
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price_per_day', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price_per_day', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'year_asc':
                    $query->orderBy('year', 'asc');
                    break;
                case 'year_desc':
                    $query->orderBy('year', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        // Get available cars only
        $cars = $query->where('disponible', true)->get();

        // Prepare data for response
        $carsData = $cars->map(function($car) {
            return [
                'id' => $car->id,
                'name' => $car->name,
                'category' => $car->category,
                'description' => $car->description,
                'price_per_day' => $car->price_per_day,
                'year' => $car->year,
                'seats' => $car->seats,
                'transmission' => $car->transmission,
                'fuel_type' => $car->fuel_type,
                'license_plate' => $car->license_plate,
                'image_url' => asset($car->image_url),
                'status' => $car->status ?? 'available',
            ];
        });

        \Log::info('Filter results count:', ['count' => $carsData->count()]);

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
}
