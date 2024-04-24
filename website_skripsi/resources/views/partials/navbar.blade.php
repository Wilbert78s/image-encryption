<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light nav shadow">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="/img/usu.png" alt="" width="50" height="50" class="d-inline-block align-text-top" />
      </a>
      <a class="navbar-brand" href="/home">Universitas Sumatera Utara </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        @auth
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/encrypt">Encrypt</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/decrypt">Decrypt</a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Welcome back, {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu">
              {{-- <li><a class="dropdown-item" href="#">My Dashboard</a></li> --}}
              {{-- <li><hr class="dropdown-divider"></li> --}}
              <li>
                <form action="/logout" method="post">
                  @csrf
                  <button type="submit" class="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          </li>
        </ul>
        {{-- @else
          <li class="nav-item">
              <a href="/login" class="nav-link {{ ($active === "login") ? 'active' :'' }}"><i class="bi bi-box-arrow-right"></i> Login</a>
          </li> --}}
        @endauth
      </div>

    </div>
  </nav>
  <!-- Navbar End-->
