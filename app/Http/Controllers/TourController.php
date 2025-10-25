<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::active()->latest()->paginate(12);
        return view('pages.tours.grid', compact('tours'));
    }

    public function show($slug)
    {
        $tour = Tour::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('pages.tours.details', compact('tour'));
    }

    public function booking($slug)
    {
        $tour = Tour::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('pages.tours.booking', compact('tour'));
    }
}
