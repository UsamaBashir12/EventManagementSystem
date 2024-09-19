@extends('layouts.user')

@section('content')
  <div class="container mt-5">
    <!-- Navigation Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 p-2 border border-1 rounded-2 shadow-sm custom-nav">
      <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
      </a>
      <a href="{{ route('user.dashboard', ['event' => $event->id]) }}" class="btn btn-info">
        <i class="bi bi-chevron-right"></i> Go
      </a>
    </div>

    <div class="text-center mb-5">
      <h1 class="display-4 text-primary">Book Your Event</h1>
      <p class="lead">Secure your spot for <span class="text-secondary">{{ $event->name }}</span></p>
    </div>

    <div class="card shadow-lg border-light custom-card">
      <div class="card-body">
        <form id="bookingForm" action="{{ route('events.book', ['event' => $event->id]) }}" method="POST"
          onsubmit="return validateForm()">
          @csrf

          <!-- Error Message Container -->
          <div id="error-message" class="alert alert-danger d-none mb-3"></div>

          <!-- Ticket Fields -->
          @php
            $tickets = [
                [
                    'type' => 'free',
                    'label' => 'Free Tickets',
                    'price' => 0,
                    'remaining' => $remainingFreeTickets,
                    'limitReached' => $freeTicketsLimitReached,
                ],
                [
                    'type' => 'normal',
                    'label' => 'Normal Tickets',
                    'price' => 95,
                    'remaining' => $remainingNormalTickets,
                    'limitReached' => $normalTicketsLimitReached,
                ],
                [
                    'type' => 'all',
                    'label' => 'All Tickets',
                    'price' => 120,
                    'remaining' => $remainingAllTickets,
                    'limitReached' => $allTicketsLimitReached,
                ],
                [
                    'type' => 'business',
                    'label' => 'Business Tickets',
                    'price' => 150,
                    'remaining' => $remainingBusinessTickets,
                    'limitReached' => $businessTicketsLimitReached,
                ],
                [
                    'type' => 'first',
                    'label' => 'First Class Tickets',
                    'price' => 200,
                    'remaining' => $remainingFirstClassTickets,
                    'limitReached' => $firstClassTicketsLimitReached,
                ],
            ];
          @endphp

          @foreach ($tickets as $ticket)
            <div class="mb-4">
              @if ($ticket['limitReached'])
                <div class="alert alert-danger mb-2">
                  <strong>{{ $ticket['label'] }}</strong> are fully booked. Please choose another type.
                </div>
              @else
                <div class="form-group">
                  <label for="{{ $ticket['type'] }}_quantity" class="form-label">
                    {{ $ticket['label'] }} ({{ $ticket['remaining'] }} remaining):
                  </label>
                  <input type="number" name="{{ $ticket['type'] }}_quantity" id="{{ $ticket['type'] }}_quantity"
                    class="form-control ticket-quantity" value="0" min="0" max="{{ $ticket['remaining'] }}"
                    data-price="{{ $ticket['price'] }}" required>
                  <small class="form-text text-muted">Price: ${{ $ticket['price'] }}</small>
                </div>
              @endif
            </div>
          @endforeach

          <!-- Total Price -->
          <div class="mb-4">
            <h4 class="font-weight-bold">Total Price: $<span id="total-price">0</span></h4>
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary custom-button">Book Now</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Function to validate the form
    function validateForm() {
      const ticketInputs = document.querySelectorAll('.ticket-quantity');
      let hasTickets = false;
      const errorMessageContainer = document.getElementById('error-message');

      ticketInputs.forEach(input => {
        if (parseInt(input.value) > 0) {
          hasTickets = true;
        }
      });

      if (!hasTickets) {
        errorMessageContainer.textContent = 'Please select at least one ticket before booking.';
        errorMessageContainer.classList.remove('d-none');
        return false; // Prevent form submission
      }

      errorMessageContainer.classList.add('d-none');
      return true; // Allow form submission
    }

    // Function to update the total price dynamically
    function updateTotalPrice() {
      const ticketInputs = document.querySelectorAll('.ticket-quantity');
      let totalPrice = 0;

      ticketInputs.forEach(input => {
        const quantity = parseInt(input.value) || 0;
        const price = parseInt(input.getAttribute('data-price'));
        totalPrice += quantity * price;
      });

      document.getElementById('total-price').textContent = totalPrice;
    }

    // Add event listeners to ticket quantity inputs to recalculate total price on change
    document.querySelectorAll('.ticket-quantity').forEach(input => {
      input.addEventListener('input', updateTotalPrice);
    });
  </script>
  <style>
    /* Custom CSS for the booking page */

    .custom-nav {
      background-color: #f8f9fa;
    }

    .custom-card {
      border-radius: 10px;
    }

    .custom-card .card-body {
      padding: 2rem;
    }

    .custom-button {
      background-color: #007bff;
      border-color: #007bff;
    }

    .custom-button:hover {
      background-color: #0056b3;
      border-color: #004085;
    }

    .text-primary {
      color: #007bff;
    }

    .text-secondary {
      color: #6c757d;
    }

    .font-weight-bold {
      font-weight: 700;
    }
  </style>
@endsection
