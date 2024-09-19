@extends('layouts.layout')

@section('title', $event->title)

@section('content')
  <div class="container mt-5">
    <div class="row mb-4">
      <!-- Event Header -->
      <div class="col-md-8">
        <h1 class="event-title">{{ $event->title }}</h1>
        <p class="event-info"><strong>Date:</strong> {{ $event->start_date->format('F j, Y') }}</p>
        <p class="event-info"><strong>Time:</strong> {{ $event->start_date->format('g:i A') }}</p>
        <p class="event-info"><strong>Location:</strong> {{ $event->location }}</p>
        <p class="event-info"><strong>Organizer:</strong> {{ $organizer->name }}</p>
      </div>

      <!-- Event Image -->
      <div class="col-md-4">
        <img src="{{ $event->image ? asset('storage/' . $event->image) : asset('images/default_image.png') }}"
          alt="{{ $event->title }}" class="img-fluid rounded shadow-lg event-image">
      </div>
    </div>

    <!-- Event Description -->
    <div class="mb-4">
      <h2 class="section-title">Description</h2>
      <p class="event-description">{{ $event->description }}</p>
    </div>

    <!-- Booking Details -->
    <div class="mb-4">
      <h3 class="section-title">Booking Details</h3>
      <div class="row">
        @foreach ([['type' => 'Free Tickets', 'quantity' => $event->free_quantity, 'color' => 'primary'], ['type' => 'Normal Tickets', 'quantity' => $event->normal_quantity, 'color' => 'secondary'], ['type' => 'All Tickets', 'quantity' => $event->all_quantity, 'color' => 'info'], ['type' => 'Business Tickets', 'quantity' => $event->business_quantity, 'color' => 'success'], ['type' => 'First Class Tickets', 'quantity' => $event->first_quantity, 'color' => 'warning']] as $ticket)
          <div class="col-md-3 mb-3">
            <div class="card border-{{ $ticket['color'] }} mb-3 ticket-card">
              <div class="card-header bg-{{ $ticket['color'] }} text-white">{{ $ticket['type'] }}</div>
              <div class="card-body">
                <p class="card-text">{{ $ticket['quantity'] }} available</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Booking List -->
    <div class="mb-4">
      @if ($bookings->count())
        <h3 class="section-title">Bookings</h3>
        <ul class="list-group booking-list">
          @foreach ($bookings as $booking)
            <li class="list-group-item">
              {{ $booking->user->name }}: ${{ number_format($booking->total_price, 2) }}
            </li>
          @endforeach
        </ul>
      @else
        <p>No bookings yet.</p>
      @endif
    </div>

    <!-- Booking Button -->
    <div>
      <a href="{{ route('user.book', ['event' => $event->id]) }}" class="btn btn-primary btn-lg book-button">Book This
        Event</a>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    .event-title {
      font-size: 2.5rem;
      font-weight: bold;
      color: #333;
    }

    .event-info {
      font-size: 1.25rem;
      margin-bottom: 0.5rem;
      color: #555;
    }

    .event-image {
      max-height: 300px;
      object-fit: cover;
    }

    .section-title {
      font-size: 1.75rem;
      border-bottom: 2px solid #007bff;
      padding-bottom: 0.5rem;
      margin-bottom: 1rem;
    }

    .event-description {
      font-size: 1.125rem;
      color: #666;
    }

    .ticket-card {
      border-radius: 0.5rem;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .booking-list .list-group-item {
      border: 1px solid #ddd;
      border-radius: 0.25rem;
    }

    .book-button {
      font-size: 1.125rem;
    }
  </style>
@endpush
