<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title')</title>
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-2 shadow">
        <div class="row justify-content-between">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">BoolPress</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed w-25 start-50" type="button"
                data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap ms-2">
                <a class="btn btn-secondary" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </header>

    <div class="app-wrapper container-fluid vh-100">
        <div class="row h-100">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark navbar-dark sidebar collapse">
                <div class="position-sticky py-3">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-3">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link text-light text-center {{ Route::currentRouteName() === 'admin.dashboard' ? 'bg-secondary' : '' }}">
                                <i class="fa-solid fa-gauge"></i>
                                Dasboard
                            </a>

                            <a href="{{ route('admin.projects.index') }}"
                                class="nav-link text-light text-center {{ Route::currentRouteName() === 'admin.projects.index' ? 'bg-secondary' : '' }}">
                                <i class="fa-solid fa-border-all"></i>
                                Tutti i progetti
                            </a>
                            @if (Auth::check() && Auth::user()->isAdmin())
                                <a href="{{ route('admin.types.index') }}"
                                    class="nav-link text-white text-center {{ Route::currentRouteName() == 'admin.types.index' ? 'bg-secondary' : '' }}">
                                    <i class="fa-solid fa-folder-open fa-lg fa-fw"></i> Categories
                                </a>
                                <a class="nav-link text-white text-center" href="#">
                                    <i class="fa-solid fa-bookmark fa-lg fa-fw"></i> Tags
                                </a>
                                <a class="nav-link text-white text-center" href="#">
                                    <i class="fa-solid fa-users fa-lg fa-fw"></i> Users
                                </a>
                            @endif


                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 col-lg-10 d-md-block">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
