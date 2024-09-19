{{-- Top Bar --}}


{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <!-- Logo on the left side -->
    <a class="navbar-brand" href="{{ route('home') }}">
      <img src="path/to/logo.png" alt="Logo" style="height: 40px;"> <!-- Add your logo path -->
    </a>

    <!-- Toggler for mobile view -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar items -->
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
      <!-- Centered nav links -->
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('events') }}">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('organizer') }}">Organizers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('contact') }}">Contact</a>
        </li>
      </ul>

      <!-- Buttons on the right side -->
      <div class="d-flex">
        <!-- Customer button with dropdown -->
        @if (Auth::check() && Auth::user()->role_id != 2)
          <div class="btn-group me-2">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
              aria-expanded="false">
              {{ Auth::user()->first_name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
              <li><a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </ul>
          </div>
        @elseif (!Auth::check())
          <div class="btn-group me-2">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
              aria-expanded="false">
              Customer
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
              <li><a class="dropdown-item" href="{{ route('register') }}">Signup</a></li>
            </ul>
          </div>
        @endif

        <!-- Organizer button with dropdown -->
        @if (Auth::check() && Auth::user()->role_id == 2)
          <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
              aria-expanded="false">
              {{ Auth::user()->first_name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('organizer.dashboard') }}">Dashboard</a></li>
              <li><a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </ul>
          </div>
        @elseif (!Auth::check())
          <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
              aria-expanded="false">
              Organizer
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
              <li><a class="dropdown-item" href="{{ route('register') }}">Signup</a></li>
            </ul>
          </div>
        @endif
      </div>
    </div>
  </div>
</nav>

<style>
  .navbar {
    padding: 1rem 2rem;
  }

  .navbar-brand img {
    height: 40px;
    /* Adjust the size of your logo here */
  }

  .navbar-nav .nav-link {
    font-size: 1rem;
    font-weight: 500;
    color: #333;
  }

  .navbar-nav .nav-link:hover {
    color: #0056b3;
    /* Change color on hover */
  }

  .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
  }

  .btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
  }

  .dropdown-menu {
    border-radius: 0.25rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
  }

  .dropdown-item:hover {
    background-color: #f8f9fa;
    color: #0056b3;
  }

  .dropdown-item:focus,
  .dropdown-item.active {
    background-color: #e9ecef;
    color: #0056b3;
  }
</style>
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery (optional, but needed if you're using Bootstrap 4 or earlier) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (required for Bootstrap dropdowns) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
