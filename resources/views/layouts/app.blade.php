<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') | Task Manager</title>
  <link rel="shortcut icon" href="{{ asset('assets/img/logo-circle.png') }}" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

  <style>
    body {
      margin: 0;
      font-family: "Noto Sans", sans-serif !important;
      background-color: #f4f5f7;
    }
    /* Navbar style inspiré de Trello */
    .navbar {
      background-color: #026AA7;
    }
    .navbar-brand img {
      filter: invert(100%);
    }
    .nav-link {
      color: white !important;
      font-size: .875rem;
      padding: .25rem .5rem;
    }
    .nav-link.active, .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 0.25rem;
    }
    footer {
      background-color: #ffffff;
      box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <!-- Logo et titre -->
      <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img src="{{ asset('assets/img/logo-circle-horizontal.png') }}" alt="Task Manager" class="img-fluid" width="120">
      </a>
      <!-- Bouton pour responsive -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTrello" aria-controls="navbarTrello" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Liens de navigation et informations utilisateur -->
      <div class="collapse navbar-collapse" id="navbarTrello">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('dashboard') }}">
              <i class="bi bi-house-door"></i> Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('projects*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
              <i class="bi bi-folder"></i> Projects
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('reminders*') ? 'active' : '' }}" href="{{ route('reminders.index') }}">
              <i class="bi bi-bell"></i> Reminders
            </a>
          </li>
        </ul>
        <!-- Affichage de la date/heure actuelle -->
        <span class="navbar-text me-3" id="currentDateTime"></span>
        <!-- Dropdown utilisateur -->
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                  @csrf
                  <button type="submit" class="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container-fluid p-4">
    @yield('content')
  </main>

  <footer class="text-center py-3">
    <div class="container">
      <span class="text-muted">&copy; {{ date('Y') }} Task Manager | Developed by <a href="https://github.com/mriahi635" target="_blank">Marouane RIAHI IDRISSI</a></span>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function updateDateTime() {
      const now = new Date();
      const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
      const day = dayNames[now.getDay()];
      const date = now.toLocaleDateString(['en-US'], { day: 'numeric', month: 'long', year: 'numeric' });
      const time = now.toLocaleTimeString();
      document.getElementById('currentDateTime').innerText = `${day}, ${date} ${time}`;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);
  </script>
</body>
</html>
