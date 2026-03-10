<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админ-панель') - AKMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar vh-100 position-fixed">
                <div class="position-sticky pt-3">
                    <h5 class="text-white text-center py-3 border-bottom">GameMarket Admin</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Дашборд
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active bg-primary' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people me-2"></i>Пользователи
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.games.*') ? 'active bg-primary' : '' }}" href="{{ route('admin.games.index') }}">
                                <i class="bi bi-controller me-2"></i>Аккаунты
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.orders.*') ? 'active bg-primary' : '' }}" href="{{ route('admin.orders.index') }}">
                                <i class="bi bi-cart me-2"></i>Заказы
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link text-white" href="{{ route('home') }}">
                                <i class="bi bi-house me-2"></i>На сайт
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Выйти
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 16.666%!important;">
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('header')</h1>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>