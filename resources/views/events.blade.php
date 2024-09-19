@extends('layouts.layout')

@section('title', 'Events')

@section('content')
  <div class="container my-5">
    <div class="row">
      {{-- Sidebar --}}
      <div class="col-md-3">
        <form method="GET" action="" class="filter-form">
          <!-- Search Bar -->
          <div class="form-group">
            <label for="search" class="form-label">Search</label>
            <input type="search" class="form-control" id="search" name="search" placeholder="Search events"
              value="{{ request('search') }}">
          </div>

          <!-- Filter by Date -->
          <div class="form-group">
            <label for="startDate" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="startDate" name="start_date"
              value="{{ request('start_date') }}">
          </div>
          <div class="form-group">
            <label for="endDate" class="form-label">End Date</label>
            <input type="date" class="form-control" id="endDate" name="end_date" value="{{ request('end_date') }}">
          </div>

          <!-- Location Field -->
          <div class="form-group">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Enter location"
              value="{{ request('location') }}">
          </div>

          <!-- Category Field -->
          <div class="form-group">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category">
              <option value="">Select category</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                  {{ $category->title }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Price Filter -->
          <div class="form-group">
            <label for="priceRange" class="form-label">Price Range ($)</label>
            <input type="range" class="form-range" id="priceRange" name="price_range" min="0" max="1000"
              step="10" value="{{ request('price_range', 500) }}" oninput="updatePriceRange(this.value)">
            <div class="mt-2">Selected Price: $<span id="priceRangeValue">{{ request('price_range', 500) }}</span>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Apply Filters</button>
        </form>
      </div>

      {{-- Main Content --}}
      <div class="col-md-9">
        <h2 class="text-center mb-4">Events</h2>

        {{-- Events List --}}
        <div class="row mt-4">
          @forelse ($events as $event)
            <div class="col-md-4 d-flex flex-wrap mb-4">
              <div class="card h-100 w-100 shadow-sm border-light">
                <img class="card-img-top"
                  src="{{ $event->image ? asset('storage/' . $event->image) : asset('images/default_image.png') }}"
                  alt="{{ $event->title }}">
                <div class="card-body">
                  <h5 class="text-primary">By: {{ $event->organizer->first_name }}</h5>
                  <h3 class="card-title">{{ $event->title }}</h3>
                  <p class="card-text"><b>Description:</b> {{ Str::limit($event->description, 150) }}</p>
                  <p class="card-text"><b>Price:</b> ${{ number_format($event->price, 2) }}</p>
                </div>

                <div class="card-footer">
                  @if ($event->id)
                    <a href="{{ route('user.book', ['event' => $event->id]) }}" class="btn btn-primary">Book Event</a>
                    <a href="{{ route('event.details', ['event' => $event->id]) }}" class="btn btn-secondary">View
                      Details</a>
                  @else
                    <span>No booking available</span>
                  @endif
                  <div id="countdown-{{ $event->id }}" class="countdown">Loading...</div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <p class="empty-message">No events available for the selected category. Please check back later!</p>
            </div>
          @endforelse
        </div>

        {{-- Pagination --}}
        <div class="pagination-container mt-4">
          {{ $events->links() }}
        </div>
      </div>
    </div>
  </div>

  <script>
    function updatePriceRange(value) {
      document.getElementById('priceRangeValue').textContent = value;
    }
  </script>
  <style>
    /* Custom CSS for Events Page */

    .banner {
      background: linear-gradient(to right, #2c3e50, #3498db);
      color: white;
      padding: 60px 20px;
      text-align: center;
    }

    .banner h1 {
      font-size: 3rem;
      font-weight: bold;
    }

    .banner p {
      font-size: 1.5rem;
      margin-top: 10px;
    }

    .filter-form {
      border: 1px solid #dee2e6;
      border-radius: .375rem;
      padding: 20px;
      background-color: #ffffff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .filter-form .form-group {
      margin-bottom: 1.5rem;
    }

    .filter-form input[type="range"] {
      width: 100%;
    }

    .card-img-top {
      height: 250px;
      object-fit: cover;
    }

    .card-body {
      padding: 1.25rem;
    }

    .card-footer {
      background: #f8f9fa;
      border-top: 1px solid #dee2e6;
    }

    .empty-message {
      padding: 2rem;
      text-align: center;
      font-size: 1.25rem;
      color: #6c757d;
    }

    .pagination-container {
      display: flex;
      justify-content: center;
    }

    .pagination .page-link {
      border-radius: .375rem;
      color: #007bff;
    }

    .pagination .page-link:hover {
      background-color: #e9ecef;
      color: #0056b3;
    }

    .pagination .page-item.active .page-link {
      background-color: #007bff;
      border-color: #007bff;
      color: #ffffff;
    }

    .pagination .page-item.disabled .page-link {
      color: #6c757d;
    }
  </style>
  <style>
    .banner-img-setting img {
      object-fit: cover;
      height: 100vh;
      width: 100%;
      border-bottom: 5px solid #3498db;
    }

    .search-container {
      max-width: 800px;
      margin-top: -50px;
      z-index: 1;
      position: relative;
    }

    .search-input {
      border-radius: 0.25rem;
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .search-button {
      border-radius: 0.25rem;
    }

    .card {
      border-radius: 0.75rem;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
    }

    .card-header img {
      object-fit: cover;
      border-bottom: 2px solid #ddd;
      height: 250px;
      transition: transform 0.3s ease;
    }

    .card-header img:hover {
      transform: scale(1.05);
    }

    .card-body {
      padding: 1.5rem;
      background: #fff;
    }

    .card-footer {
      background-color: #f8f9fa;
      border-top: 1px solid #ddd;
      padding: 1rem;
      text-align: center;
    }

    .countdown {
      font-size: 1.2rem;
      font-weight: bold;
      color: #007bff;
      margin-top: 1rem;
    }

    .btn-primary,
    .btn-secondary {
      border-radius: 50px;
      padding: 0.5rem 1.5rem;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0056b3;
      transform: scale(1.05);
    }

    .btn-secondary {
      background-color: #6c757d;
      border: none;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
      transform: scale(1.05);
    }

    .category-card img {
      border-radius: 0.75rem;
    }

    .category-card {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      border-radius: 0.75rem;
      overflow: hidden;
    }

    .category-card p {
      margin: 0;
      font-weight: bold;
    }

    .text-primary {
      color: #3498db !important;
    }

    @media (max-width: 768px) {

      .card-body,
      .card-footer {
        text-align: left;
      }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      function initializeCountdown(eventId, countdownDate) {
        const countdownElement = document.getElementById(`countdown-${eventId}`);

        function updateCountdown() {
          const now = new Date().getTime();
          const distance = countdownDate - now;

          if (distance < 0) {
            countdownElement.innerHTML = "Event Started!";
            clearInterval(interval);
            return;
          }

          const days = Math.floor(distance / (1000 * 60 * 60 * 24));
          const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          const seconds = Math.floor((distance % (1000 * 60)) / 1000);

          countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }

        const interval = setInterval(updateCountdown, 1000);
        updateCountdown();
      }

      @foreach ($events as $event)
        const countdownDate{{ $event->id }} = new Date("{{ $event->start_date }}T{{ $event->start_time }}")
          .getTime();
        initializeCountdown({{ $event->id }}, countdownDate{{ $event->id }});
      @endforeach
    });
  </script>

@endsection
