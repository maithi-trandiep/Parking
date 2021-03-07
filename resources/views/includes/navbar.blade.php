<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index" class="nav-link">Accueil</a>
        </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Rechercher" aria-label="Search">
            <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
            </button>
            </div>
        </div>
        </form>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index" class="brand-link">
        <img src="{{ asset('assets/img/logo.jpg') }}" alt="GE logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Parking</span>
        </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets/img/user_photo.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Rechercher" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            
            @if(Auth::check() && Auth::user()->isAdmin())            
            <li class="nav-header">UTILISATEUR</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Gestion d'utilisateurs
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('show') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste des statuts</p>
                    </a>
                </li>
                </ul>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste des utilisateurs</p>
                    </a>
                </li>
                </ul>
            </li>
            <li class="nav-header">PLACE</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-car"></i>
                <p>
                    Gestion de place
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('places.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste des places</p>
                    </a>
                </li>
                </ul>
            </li>
            <li class="nav-header">RESERVATION</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                    Gestion de réservation
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste des réservations</p>
                    </a>
                </li>
                </ul>
            </li>
            @else
            <li class="nav-header">RESERVATION</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>
                        Consulter la réservation
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('user-reservations.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Faire une réservation</p>
                    </a>
                    </li>
                    </ul>
            </li>
            @endif
            <li class="nav-header"></li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class=" nav-icon fas fa-sign-out-alt"></i>
                    <p>
                        Se déconnecter
                    </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->