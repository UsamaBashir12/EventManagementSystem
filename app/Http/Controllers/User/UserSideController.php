<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserSideController extends Controller
{
  public function dashboard()
  {
    $today = Carbon::today()->toDateString();

    \Log::info("Today's Date: " . $today);

    // Retrieve all events start  ing from today
    $events = Event::whereDate('start_date', '>=', $today)
      ->get();

    \Log::info('Retrieved Events:', $events->toArray());

    $organizers = User::where('role_id', 2)->get(); // Organizers
    $categories = Category::all();

    return view('user.dashboard', compact('events', 'categories', 'organizers'));
  }

  // UserSideController.php
  public function showEventDetails($eventId)
  {
    // Retrieve the event by its ID
    $event = Event::findOrFail($eventId);

    // Convert start_date to a Carbon instance if it's a string
    $event->start_date = \Carbon\Carbon::parse($event->start_date);

    // Other logic
    $organizer = $event->organizer; // Assuming relationship is defined
    $bookings = Booking::where('event_id', $eventId)->get();

    return view('user.event-details', compact('event', 'organizer', 'bookings'));
  }


  public function showBookingForm($eventId)
  {
    // Get the event based on the ID passed in the route
    $event = Event::findOrFail($eventId);

    // Sum the booked tickets specifically for this event (using the event_id)
    $totalFreeTicketsBooked = Booking::where('event_id', $eventId)->sum('free_quantity');
    $totalNormalTicketsBooked = Booking::where('event_id', $eventId)->sum('normal_quantity');
    $totalAllTicketsBooked = Booking::where('event_id', $eventId)->sum('all_quantity');
    $totalBusinessTicketsBooked = Booking::where('event_id', $eventId)->sum('business_quantity');
    $totalFirstClassTicketsBooked = Booking::where('event_id', $eventId)->sum('first_quantity');

    // Assuming the maximum limit of each ticket type is 5 (this can be different per event if needed)
    $maxTickets = 5;

    // Calculate remaining tickets for this specific event
    $remainingFreeTickets = max($maxTickets - $totalFreeTicketsBooked, 0);
    $remainingNormalTickets = max($maxTickets - $totalNormalTicketsBooked, 0);
    $remainingAllTickets = max($maxTickets - $totalAllTicketsBooked, 0);
    $remainingBusinessTickets = max($maxTickets - $totalBusinessTicketsBooked, 0);
    $remainingFirstClassTickets = max($maxTickets - $totalFirstClassTicketsBooked, 0);

    // Check if the limits are reached (per event)
    $freeTicketsLimitReached = $remainingFreeTickets <= 0;
    $normalTicketsLimitReached = $remainingNormalTickets <= 0;
    $allTicketsLimitReached = $remainingAllTickets <= 0;
    $businessTicketsLimitReached = $remainingBusinessTickets <= 0;
    $firstClassTicketsLimitReached = $remainingFirstClassTickets <= 0;

    // Return the view for booking form for this specific event, with the data
    return view('user.book', compact(
      'event',
      'remainingFreeTickets',
      'remainingNormalTickets',
      'remainingAllTickets',
      'remainingBusinessTickets',
      'remainingFirstClassTickets',
      'freeTicketsLimitReached',
      'normalTicketsLimitReached',
      'allTicketsLimitReached',
      'businessTicketsLimitReached',
      'firstClassTicketsLimitReached'
    ));
  }






  public function book(Request $request, int $eventId)
  {
    // Find the event by ID
    $event = Event::findOrFail($eventId);

    // Validate the request input
    $validated = $request->validate([
      'free_quantity' => 'required|integer|min:0',
      'normal_quantity' => 'required|integer|min:0',
      'all_quantity' => 'required|integer|min:0',
      'business_quantity' => 'required|integer|min:0',
      'first_quantity' => 'required|integer|min:0',
    ]);

    // Define ticket prices
    $ticketPrices = [
      'free_quantity' => 0,
      'normal_quantity' => 95,
      'all_quantity' => 120,
      'business_quantity' => 150,
      'first_quantity' => 200,
    ];

    // Total ticket limit per event (can be customized)
    $maxTicketsPerEvent = 5;

    // Get the total number of tickets already booked for the event across all users
    $totalTicketsBooked = Booking::where('event_id', $eventId)
      ->sum(DB::raw('free_quantity + normal_quantity + all_quantity + business_quantity + first_quantity'));

    // Calculate the total number of tickets requested in this booking
    $totalRequestedTickets = array_sum($validated);

    // Check if booking exceeds the limit of 5 tickets per event
    if (($totalTicketsBooked + $totalRequestedTickets) > $maxTicketsPerEvent) {
      return redirect()->back()->with('error', 'Booking these tickets would exceed the limit of ' . $maxTicketsPerEvent . ' tickets for this event.');
    }

    // Calculate the total price of the tickets
    $totalPrice = collect($validated)->reduce(function ($carry, $quantity, $ticketType) use ($ticketPrices) {
      return $carry + ($quantity * $ticketPrices[$ticketType]);
    }, 0);

    // Store the booking in the database
    Booking::create([
      'event_id' => $event->id,
      'user_id' => auth()->id(),
      'free_quantity' => $validated['free_quantity'],
      'normal_quantity' => $validated['normal_quantity'],
      'all_quantity' => $validated['all_quantity'],
      'business_quantity' => $validated['business_quantity'],
      'first_quantity' => $validated['first_quantity'],
      'total_price' => $totalPrice,
    ]);

    // Redirect with a success message
    return redirect()->route('user.dashboard')->with('success', 'Tickets successfully booked!');
  }




  public function showBookedEvents()
  {
    // Fetch the current user's booked events
    $userId = auth()->id();

    // Fetch the bookings along with event details
    $bookedEvents = Booking::with('event')
      ->where('user_id', $userId)
      ->get();

    // Pass the bookings to the view
    return view('user.booked-events', compact('bookedEvents'));
  }



  /**
   * Show the booking form for an event.
   *
   * @param int $eventId
   * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
   */

  public function confirmBooking(Request $request, $eventId)
  {
    // Handle booking logic here
    // For example, you might save the booking to the database

    // Redirect to a confirmation page or back with a success message
    return redirect()->route('book.event', ['events' => $eventId])->with('success', 'Booking confirmed!');
  }
  /**
   * Book an event.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $eventId
   * @return \Illuminate\Http\RedirectResponse
   */
}
