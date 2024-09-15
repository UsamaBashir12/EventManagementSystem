@extends('layouts.layout')

@section('title', 'Organizers')

@section('content')
  <style>
    .card {
      border-radius: 0.5rem;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease-in-out;
    }

    .card:hover {
      transform: scale(1.05);
    }

    .card-title {
      font-size: 1.25rem;
      font-weight: 500;
    }

    .card-subtitle {
      font-size: 1rem;
      color: #6c757d;
    }

    .card-text {
      font-size: 0.9rem;
      color: #333;
    }

    .btn-info {
      border-radius: 0.25rem;
      padding: 0.5rem 1rem;
    }

    .alert-info {
      border-radius: 0.5rem;
      font-size: 1.1rem;
    }
  </style>

  <div class="container my-5">
    <h2 class="text-center mb-4">All Organizers</h2>

    @if ($organizers->isEmpty())
      <div class="alert alert-info text-center" role="alert">
        No organizers found.
      </div>
    @else
      <div class="row">
        @foreach ($organizers as $organizer)
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{ $organizer->first_name }} {{ $organizer->last_name }}</h5>
                <h6 class="card-subtitle mb-2">{{ $organizer->email }}</h6>
                <p class="card-text">
                  <strong>Phone:</strong> {{ $organizer->phone }}<br>
                  <strong>Gender:</strong> {{ ucfirst($organizer->gender) }}<br>
                  <strong>Date of Birth:</strong>
                  {{ $organizer->dob ? \Carbon\Carbon::parse($organizer->dob)->format('d M, Y') : 'N/A' }}<br>
                  <strong>Status:</strong> {{ ucfirst($organizer->status) }}<br>
                  <strong>Joined At:</strong> {{ $organizer->created_at->format('d M, Y') }}<br>
                  <strong>Is Active:</strong> {{ $organizer->is_active ? 'Active' : 'Inactive' }}
                </p>
                <a href="#" class="btn btn-info">View Details</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endsection
