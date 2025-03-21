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
        $cars = Car::latest()->paginate(10);
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'seats' => 'required|integer|min:1',
            'transmission' => 'required|string',
            'fuel_type' => 'required|string',
            'license_plate' => 'required|string|max:20|unique:cars',
            'status' => 'required|in:available,rented,maintenance',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Process the image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            $validatedData['image_url'] = 'storage/' . $imagePath;
        }

        // Set availability based on status
        $validatedData['disponible'] = ($validatedData['status'] === 'available') ? true : false;

        Car::create($validatedData);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car added successfully');
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'seats' => 'required|integer|min:1',
            'transmission' => 'required|string',
            'fuel_type' => 'required|string',
            'license_plate' => 'required|string|max:20|unique:cars,license_plate,' . $car->id,
            'status' => 'required|in:available,rented,maintenance',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Process the image if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($car->image_url && Storage::disk('public')->exists(str_replace('storage/', '', $car->image_url))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $car->image_url));
            }

            $imagePath = $request->file('image')->store('cars', 'public');
            $validatedData['image_url'] = 'storage/' . $imagePath;
        }

        // Set availability based on status
        $validatedData['disponible'] = ($validatedData['status'] === 'available') ? true : false;

        $car->update($validatedData);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car updated successfully');
    }

    /**
     * Remove the specified car from storage.
     */
    public function destroy(Car $car)
    {
        // Check if car is currently rented
        if ($car->status === 'rented') {
            return back()->with('error', 'Cannot delete a car that is currently rented');
        }

        // Delete the car image if it exists
        if ($car->image_url && Storage::disk('public')->exists(str_replace('storage/', '', $car->image_url))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $car->image_url));
        }

        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car deleted successfully');
    }

    /**
     * Update car availability status.
     */
    public function updateStatus(Request $request, Car $car)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:available,maintenance',
        ]);

        // Only allow changing to available or maintenance
        // (rented status is managed through reservations)
        $car->status = $validatedData['status'];
        $car->disponible = ($validatedData['status'] === 'available');
        $car->save();

        return back()->with('success', 'Car status updated successfully');
    }
}
