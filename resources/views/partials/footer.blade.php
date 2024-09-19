{{-- footer --}}
<footer>
  <div class="container py-5">
    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <div class="logo">
          <a href="#" class="text-decoration-none h3 logo-text">Logo</a>
        </div>
        <ul class="list-unstyled contact-info">
          <li class="my-2">
            <a href="mailto:usama@mudsoft.tech" class="text-decoration-none">usama@mudsoft.tech</a>
          </li>
          <li class="my-2">
            <a href="tel:03196977218" class="text-decoration-none">03196977218</a>
          </li>
          <li class="my-2">
            <a href="https://facebook.com" class="text-decoration-none social-icon">
              <i class='bx bxl-facebook-circle fs-3'></i>
            </a>
            <a href="https://twitter.com" class="text-decoration-none social-icon">
              <i class="bx bxl-twitter fs-3"></i>
            </a>
            <a href="https://youtube.com" class="text-decoration-none social-icon">
              <i class="bx bxl-youtube fs-3"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h3 class="footer-heading">Events Category</h3>
        <ul class="list-unstyled">
          <li class="my-2">
            <a href="#" class="text-decoration-none">News Reporting</a>
          </li>
          <li class="my-2">
            <a href="#" class="text-decoration-none">Extra Servicing</a>
          </li>
          <li class="my-2">
            <a href="#" class="text-decoration-none">Reliable Services</a>
          </li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h3 class="footer-heading">Legal</h3>
        <ul class="list-unstyled">
          <li class="my-2">
            <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
          </li>
          <li class="my-2">
            <a href="{{ route('register') }}" class="text-decoration-none">Register</a>
          </li>
          <li class="my-2">
            <a href="#" class="text-decoration-none">Terms & Conditions</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="text-center bg-dark text-white py-3">
    <p class="m-0">Copyright © 2024 All rights reserved.</p>
  </div>
</footer>
<style>
  footer {
    background-color: #f8f9fa;
  }

  footer .logo {
    margin-bottom: 1rem;
  }

  footer .logo a.logo-text {
    font-weight: bold;
    color: #343a40;
  }

  footer .contact-info a {
    color: #343a40;
  }

  footer .contact-info a:hover {
    color: #007bff;
  }

  footer .social-icon {
    margin-right: 1rem;
    color: #343a40;
  }

  footer .social-icon:hover {
    color: #007bff;
  }

  footer .footer-heading {
    font-weight: bold;
    color: #343a40;
    margin-bottom: 1rem;
  }

  footer .list-unstyled a {
    color: #343a40;
  }

  footer .list-unstyled a:hover {
    color: #007bff;
    text-decoration: underline;
  }

  footer .bg-dark {
    background-color: #343a40 !important;
  }

  footer .text-white {
    color: #ffffff !important;
  }

  @media (max-width: 767px) {
    footer .row {
      text-align: center;
    }

    footer .col-lg-3 {
      margin-bottom: 2rem;
    }
  }
</style>
