<?php

namespace App\Http\Controllers;

use App\Models\Event; // Import Event model
use App\Models\Category; // Import Category model
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
  public function welcome(Request $request)
  {
    // Get today's date
    $today = Carbon::today();

    // Start the query for events that are today or upcoming
    $query = Event::whereDate('start_date', '>=', $today);
    $categoryId = $request->input('category');

    // Get categories for the filter dropdown
    $categories = Category::all();

    // Get events based on the selected category
    $eventsQuery = Event::query();

    if ($categoryId) {
      $eventsQuery->where('category_id', $categoryId);
    }

    $events = $eventsQuery->get();
    // Filter by category if selected
    if ($request->category) {
      $query->where('category_id', $request->category);
    }

    // Search by title or description
    if ($request->search) {
      $query->where(function ($q) use ($request) {
        $q->where('title', 'like', '%' . $request->search . '%')
          ->orWhere('description', 'like', '%' . $request->search . '%');
      });
    }

    // Get the filtered events
    $events = $query->get();
    $categories = Category::all(); // Fetch categories

    // Pass the data to the view
    return view('welcome', compact('events', 'categories'));
  }

  public function show($id)
  {
    // Fetch event details
    $event = Event::findOrFail($id);

    // Return the view
    return view('eventDetails', compact('event'));
  }

  public function welcoming()
  {
    $events = Event::whereDate('start_date', '>=', Carbon::today())->get();
    $categories = Category::all();

    return view('welcome', compact('events', 'categories'));
  }

  public function index(Request $request)
  {
    $query = Event::query();

    // Only show events that are today or upcoming (not past events)
    $today = Carbon::today();
    $query->whereDate('start_date', '>=', $today);

    // Apply search filter
    if ($search = $request->input('search')) {
      $query->where('title', 'like', "%{$search}%");
    }

    // Apply start date filter (optional)
    if ($startDate = $request->input('start_date')) {
      $query->whereDate('start_date', '>=', $startDate);
    }

    // Apply end date filter (optional)
    if ($endDate = $request->input('end_date')) {
      $query->whereDate('end_date', '<=', $endDate);
    }

    // Apply location filter
    if ($location = $request->input('location')) {
      $query->where('address', 'like', "%{$location}%");
    }

    // Apply category filter
    if ($category = $request->input('category')) {
      $query->where('category_id', $category);
    }

    // Apply price filter
    if ($priceRange = $request->input('price_range')) {
      $query->where('price', '<=', $priceRange);
    }

    // Apply event type filter
    if ($eventType = $request->input('event_type')) {
      $query->where('event_type', $eventType);
    }

    // Paginate results
    $events = $query->paginate(12);
    $categories = Category::all();

    // Pass categories and events to the view
    return view('events', [
      'categories' => $categories,
      'events' => $events,
    ]);
  }
}
