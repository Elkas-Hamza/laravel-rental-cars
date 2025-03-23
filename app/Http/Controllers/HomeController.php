<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Car;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        $agence = Agence::first();
        $reviews = Review::orderBy('date_coment', 'desc')->limit(5)->get();
        return view('home', compact('agence', 'reviews'));
    }

    /**
     * Submit a review
     */
    public function storeReview(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Review::create($validatedData);

        return redirect()->route('home')->with('success', 'Review submitted successfully!');
    }

    /**
     * Search for available cars
     */
    public function searchCars(Request $request)
    {
        $validatedData = $request->validate([
            'date_de_location' => 'required|date|after_or_equal:today',
            'date_de_retour' => 'required|date|after:date_de_location',
        ]);

        session([
            'date_de_location' => $validatedData['date_de_location'],
            'date_de_retour' => $validatedData['date_de_retour']
        ]);

        return redirect()->route('cars.available');
    }

    /**
     * Display the support page
     */
    public function support()
    {
        $agence = Agence::first();
        return view('pages.support', compact('agence'));
    }

    /**
     * Display the FAQ page
     */
    public function faq()
    {
        $agence = Agence::first();
        return view('pages.faq', compact('agence'));
    }

    /**
     * Display the about page
     */
    public function     about()
    {
        $agence = Agence::first();
        return view('pages.about', compact('agence'));
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        $agence = Agence::first();
        return view('pages.contact', compact('agence'));
    }
}
