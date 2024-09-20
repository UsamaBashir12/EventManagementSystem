<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
  public function welcome(Request $request)
  {
    $today = Carbon::today();
    $query = Event::whereDate('start_date', '>=', $today);
    $categoryId = $request->input('category');

    // Get categories for the filter dropdown
    $categories = Category::all();

    // Apply category filter
    if ($categoryId) {
      $query->where('category_id', $categoryId);
    }

    // Search by title or description
    if ($request->search) {
      $query->where(function ($q) use ($request) {
        $q->where('title', 'like', '%' . $request->search . '%')
          ->orWhere('description', 'like', '%' . $request->search . '%');
      });
    }

    // Paginate the filtered events
    $events = $query->paginate(10); // Change the number as needed

    // Pass the data to the view
    return view('welcome', compact('events', 'categories'));
  }

  public function show($id)
  {
    $event = Event::findOrFail($id);
    return view('eventDetails', compact('event'));
  }

  public function welcoming()
  {
    $events = Event::whereDate('start_date', '>=', Carbon::today())->paginate(10); // Use pagination here
    $categories = Category::all();

    return view('welcome', compact('events', 'categories'));
  }

  public function indexing($category = null)
  {
    // Fetch events based on the category if provided
    $query = Event::query();

    if ($category) {
      $query->where('category_id', $category);
    }

    // Paginate the results
    $events = $query->paginate(10); // Change the number as needed
    $categories = Category::all(); // Ensure categories are always defined

    // Pass events and categories to the view
    return view('events', compact('events', 'categories'));
  }

  public function index(Request $request)
  {
    $query = Event::query();
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
    $events = $query->paginate(12); // Adjust the number as needed
    $categories = Category::all();

    // Pass categories and events to the view
    return view('events', compact('categories', 'events'));
  }
}
