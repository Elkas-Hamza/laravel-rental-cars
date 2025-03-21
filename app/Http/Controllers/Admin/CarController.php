<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the cars.
     */
    public function index()
    {
        $cars = Car::latest()->paginate(12);
        return view('admin.cars.index', compact('cars'));
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
     * Display the specified car.
     */
    public function show(Car $car)
    {
        return view('admin.cars.show', compact('car'));
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
