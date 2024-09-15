@extends('layouts.layout')
<style>
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

  .pagination {
    justify-content: center;
  }
</style>
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
              <div class="card h-100 w-100">
                <div class="card-header">
                  <img class="w-100"
                    src="{{ $event->image ? asset('storage/' . $event->image) : asset('images/default_image.png') }}"
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
                  @else
                    <span>No booking available</span>
                  @endif
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <p class="text-center">No events available for the selected category. Please check back later!</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
@endsection
