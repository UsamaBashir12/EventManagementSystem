@extends('layouts.layout')

@section('title', 'Contact Us')

@section('content')
  <div class="container my-5">
    <!-- Go Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
      <h2 class="m-0">Go to Home Page</h2>
      <a href="{{ route('home') }}" class="btn btn-secondary">Go Back</a>
    </div>

    <h2 class="text-center mb-5">Contact Us</h2>

    @if (session('success'))
      <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <form action="{{ route('contact.store') }}" method="POST">
          @csrf

          <div class="form-group mb-4">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
              required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group mb-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
              required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group mb-4">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" id="subject" name="subject"
              class="form-control @error('subject') is-invalid @enderror" required>
            @error('subject')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group mb-4">
            <label for="message" class="form-label">Message</label>
            <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" rows="5"
              required></textarea>
            @error('message')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
        </form>
      </div>
    </div>
  </div>
@endsection
