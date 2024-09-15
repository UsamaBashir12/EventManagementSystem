@extends('layouts.user')

@section('content')
  <div class="container mt-5">
    <!-- Navigation Section -->
    <div class="d-flex justify-content-between align-items-center m-0 border border-1 border-black p-2 rounded-2 mb-4">
      <div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Back to user dashboard</a>
      </div>
      <div>
        <a href="{{ route('user.dashboard', ['event' => $event->id]) }}" class="btn btn-info">Go</a>
      </div>
    </div>

    <h1 class="mb-4">Book Event: {{ $event->name }}</h1>

    <div class="card shadow-sm">
      <div class="card-body">
        <form id="bookingForm" action="{{ route('events.book', ['event' => $event->id]) }}" method="POST"
          onsubmit="return validateForm()">
          @csrf

          <!-- Error Message Container -->
          <div id="error-message" class="alert alert-danger d-none mb-3"></div>

          <!-- Free Tickets Field -->
          <div class="mb-3">
            @if ($freeTicketsLimitReached)
              <div class="alert alert-danger">Free tickets are fully booked. Please choose another type.</div>
            @else
              <div class="form-group">
                <label for="free_quantity" class="form-label">Free Tickets ({{ $remainingFreeTickets }}
                  remaining):</label>
                <input type="number" name="free_quantity" id="free_quantity" class="form-control" value="0"
                  min="0" max="{{ $remainingFreeTickets }}">
              </div>
            @endif
          </div>

          <!-- Normal Tickets Field -->
          <div class="mb-3">
            @if ($normalTicketsLimitReached)
              <div class="alert alert-danger">Normal tickets are fully booked. Please choose another type.</div>
            @else
              <div class="form-group">
                <label for="normal_quantity" class="form-label">Normal Tickets ({{ $remainingNormalTickets }}
                  remaining):</label>
                <input type="number" name="normal_quantity" id="normal_quantity" class="form-control" value="0"
                  min="0" max="{{ $remainingNormalTickets }}">
              </div>
            @endif
          </div>

          <!-- All Tickets Field -->
          <div class="mb-3">
            @if ($allTicketsLimitReached)
              <div class="alert alert-danger">All tickets are fully booked. Please choose another type.</div>
            @else
              <div class="form-group">
                <label for="all_quantity" class="form-label">All Tickets ({{ $remainingAllTickets }} remaining):</label>
                <input type="number" name="all_quantity" id="all_quantity" class="form-control" value="0"
                  min="0" max="{{ $remainingAllTickets }}">
              </div>
            @endif
          </div>

          <!-- Business Tickets Field -->
          <div class="mb-3">
            @if ($businessTicketsLimitReached)
              <div class="alert alert-danger">Business tickets are fully booked. Please choose another type.</div>
            @else
              <div class="form-group">
                <label for="business_quantity" class="form-label">Business Tickets ({{ $remainingBusinessTickets }}
                  remaining):</label>
                <input type="number" name="business_quantity" id="business_quantity" class="form-control" value="0"
                  min="0" max="{{ $remainingBusinessTickets }}">
              </div>
            @endif
          </div>

          <!-- First Class Tickets Field -->
          <div class="mb-3">
            @if ($firstClassTicketsLimitReached)
              <div class="alert alert-danger">First class tickets are fully booked. Please choose another type.</div>
            @else
              <div class="form-group">
                <label for="first_quantity" class="form-label">First Class Tickets ({{ $remainingFirstClassTickets }}
                  remaining):</label>
                <input type="number" name="first_quantity" id="first_quantity" class="form-control" value="0"
                  min="0" max="{{ $remainingFirstClassTickets }}">
              </div>
            @endif
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Book Now</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function validateForm() {
      const freeQuantity = document.getElementById('free_quantity').value;
      const normalQuantity = document.getElementById('normal_quantity').value;
      const allQuantity = document.getElementById('all_quantity').value;
      const businessQuantity = document.getElementById('business_quantity').value;
      const firstQuantity = document.getElementById('first_quantity').value;

      // Get the error message container
      const errorMessageContainer = document.getElementById('error-message');

      // Check if at least one ticket quantity is greater than zero
      if (freeQuantity <= 0 && normalQuantity <= 0 && allQuantity <= 0 && businessQuantity <= 0 && firstQuantity <= 0) {
        errorMessageContainer.textContent = 'Please select at least one ticket before booking.';
        errorMessageContainer.classList.remove('d-none'); // Show the error message
        return false; // Prevent form submission
      }

      // Hide the error message if validation passes
      errorMessageContainer.classList.add('d-none');
      return true; // Allow form submission
    }
  </script>
@endsection
