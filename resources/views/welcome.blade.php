@extends('layouts.layout')

@section('title', 'Home Page')

@section('content')
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

  {{-- Banner Hero --}}
  <div class="container-fluid p-0">
    <div class="banner-img-setting">
      <img src="{{ asset('images/banners.jpg') }}" alt="Banner Image">
    </div>

    {{-- Search Bar --}}
    <div class="container d-flex justify-content-center align-items-center mt-3">
      <form action="{{ route('home') }}" method="GET" class="search-container p-4 bg-light rounded shadow">
        <div class="d-flex align-items-center">
          <select class="form-select me-2 search-input" name="category" aria-label="Select Category">
            <option value="">Choose Category</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                {{ $category->title }}
              </option>
            @endforeach
          </select>
          <input type="text" class="form-control me-2 search-input" name="search" placeholder="Search..."
            value="{{ request('search') }}" aria-label="Search">
          <button type="submit" class="btn btn-primary search-button">Search</button>
        </div>
      </form>
    </div>
    <div class="pt-5"></div>
    <div class="pt-5"></div>
    <div class="pt-5"></div>
    <div class="pt-5"></div>
    <div class="pt-5"></div>
    <div class="pt-5"></div>
    {{-- Events Section --}}
    <div class="container mt-5">
      <h2 class="text-center mb-4">Explore Our Events</h2>
      <div class="row">
        @forelse ($events as $event)
          <div class="col-md-4 mb-4">
            <div class="card h-100">
              <div class="card-header">
                <img class="w-100" src="{{ $event->image ? asset('storage/' . $event->image) : asset('images/default_image.png') }}"
                  alt="{{ $event->title }}">
              </div>
              <div class="card-body">
                <h5 class="text-primary">By: {{ $event->organizer->first_name }}</h5>
                <h3>{{ $event->title }}</h3>
                <p><b>Description:</b> {{ Str::limit($event->description, 150) }}</p>
                <p><b>Price:</b> ${{ number_format($event->price, 2) }}</p>
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
            <p class="text-center">No events available today or upcoming. Please check back later!</p>
          </div>
        @endforelse
      </div>
    </div>

    {{-- Categories Section --}}
    <div class="container my-5">
      <h3 class="text-center">Explore Categories</h3>
      <div class="row mt-4">
        @foreach ($categories as $category)
          <div class="col-md-4 mb-4">
            <a href="{{ route('events', ['category' => $category->id]) }}" class="text-decoration-none">
              <div class="card category-card h-100">
                @php
                  $imageUrl = $category->image ? asset('storage/categories/' . $category->image) : 'default-image-url';
                @endphp
                <div class="card-header">
                  <img src="{{ $imageUrl }}" alt="{{ $category->title }}" class="img-fluid">
                </div>
                <div class="card-footer">
                  <p class="text-center">{{ $category->title }}</p>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </div>

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
