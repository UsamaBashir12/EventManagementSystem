@extends('layouts.layout')

@section('title', 'Home Page')

@section('content')
  <style>
    .banner-img-setting img {
      object-fit: cover;
      height: 100vh;
      width: 100%;
    }

    .search-container {
      max-width: 800px;
    }

    .search-input {
      border-radius: 0.25rem;
    }

    .search-button {
      border-radius: 0.25rem;
    }

    .card {
      border-radius: 0.5rem;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header img {
      object-fit: cover;
      border-radius: 0.5rem 0.5rem 0 0;
      height: 250px;
    }

    .card-body {
      text-align: left;
    }

    .card-footer {
      text-align: center;
    }

    .category-card img {
      border-radius: 0.5rem;
    }

    .category-card {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 0.5rem;
    }

    .category-card p {
      margin: 0;
    }

    .text-primary {
      color: #3498db !important;
    }
  </style>

  {{-- Banner Hero --}}
  <div class="container-fluid p-0">
    <div class="banner-img-setting">
      <img src="{{ asset('images/banners.jpg') }}" alt="Banner Image">
    </div>

    {{-- Search Bar --}}
    <div class="container d-flex justify-content-center align-items-center mt-3">
      <form action="{{ route('home') }}" method="GET" class="search-container p-3 bg-light rounded shadow">
        <div class="d-flex align-items-center">
          <select class="form-select me-2 select-category" name="category" aria-label="Select Category">
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
    {{-- Events Section --}}
    <div class="container mt-5">
      <h2 class="text-center">Explore Our Events</h2>
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
@endsection
