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

    // Retrieve all events starting from today
    $events = Event::whereDate('start_date', '>=', $today)
      ->get();

    \Log::info('Retrieved Events:', $events->toArray());

    $organizers = User::where('role_id', 2)->get(); // Organizers
    $categories = Category::all();

    return view('user.dashboard', compact('events', 'categories', 'organizers'));
  }
  public function showBookingForm($eventId)
  {
    $event = Event::findOrFail($eventId);

    // Get the total number of tickets booked for each type
    $totalFreeTicketsBooked = Booking::where('event_id', $eventId)->sum('free_quantity');
    $totalNormalTicketsBooked = Booking::where('event_id', $eventId)->sum('normal_quantity');
    $totalAllTicketsBooked = Booking::where('event_id', $eventId)->sum('all_quantity');
    $totalBusinessTicketsBooked = Booking::where('event_id', $eventId)->sum('business_quantity');
    $totalFirstClassTicketsBooked = Booking::where('event_id', $eventId)->sum('first_quantity');

    // Assuming the maximum limit of each ticket type is 5
    $maxTickets = 5;

    // Calculate remaining tickets for each type
    $remainingFreeTickets = max($maxTickets - $totalFreeTicketsBooked, 0);
    $remainingNormalTickets = max($maxTickets - $totalNormalTicketsBooked, 0);
    $remainingAllTickets = max($maxTickets - $totalAllTicketsBooked, 0);
    $remainingBusinessTickets = max($maxTickets - $totalBusinessTicketsBooked, 0);
    $remainingFirstClassTickets = max($maxTickets - $totalFirstClassTicketsBooked, 0);

    // Flags to check if ticket limits are reached
    $freeTicketsLimitReached = $remainingFreeTickets <= 0;
    $normalTicketsLimitReached = $remainingNormalTickets <= 0;
    $allTicketsLimitReached = $remainingAllTickets <= 0;
    $businessTicketsLimitReached = $remainingBusinessTickets <= 0;
    $firstClassTicketsLimitReached = $remainingFirstClassTickets <= 0;

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

    // Get the total number of tickets already booked for the event across all users
    $totalTicketsBooked = Booking::where('event_id', $eventId)
      ->sum(DB::raw('free_quantity + normal_quantity + all_quantity + business_quantity + first_quantity'));

    // Calculate the total number of tickets requested in this booking
    $totalRequestedTickets = $validated['free_quantity'] + $validated['normal_quantity'] +
      $validated['all_quantity'] + $validated['business_quantity'] +
      $validated['first_quantity'];

    // Check if booking exceeds the limit of 5 tickets per event
    if ($totalTicketsBooked + $totalRequestedTickets > 5) {
      return redirect()->back()->with('error', 'Booking these tickets would exceed the limit of 5 tickets for this event.');
    }

    // Calculate the total price
    $totalPrice = array_reduce(array_keys($validated), function ($carry, $key) use ($validated, $ticketPrices) {
      return $carry + ($validated[$key] * $ticketPrices[$key]);
    }, 0);

    \Log::info('Total Price:', ['total_price' => $totalPrice]);

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
