<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المصروفات الشخصية | مصروفاتي</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-wallet2"></i>
                مصروفاتي
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}"><i class="bi bi-grid me-1"></i> الرئيسية</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('incomes.*') ? 'active' : '' }}"
                                href="{{ route('incomes.index') }}"><i class="bi bi-arrow-down-circle me-1"></i> الدخل</a>
                        </li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}"
                                href="{{ route('expenses.index') }}"><i class="bi bi-arrow-up-circle me-1"></i>
                                المصروفات</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                                href="{{ route('categories.index') }}"><i class="bi bi-tags me-1"></i> التصنيفات</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('plans.*') ? 'active' : '' }}"
                                href="{{ route('plans.index') }}"><i class="bi bi-stars me-1 text-primary"></i> الذكاء
                                الاصطناعي</a></li>
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        @if(!Request::is('/'))
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a></li>
                            <li class="nav-item ms-2"><a class="btn btn-primary btn-sm px-3 text-white"
                                    href="{{ route('register') }}">إنشاء حساب</a></li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px;">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 rounded-3"
                                aria-labelledby="navbarDropdown">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item rounded py-2 text-danger">
                                            <i class="bi bi-box-arrow-left me-2"></i> تسجيل خروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px; min-height: calc(100vh - 160px);">
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center shadow-sm border-0 rounded-3 animate-fade-in-up"
                role="alert">
                <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('updated'))
            <div class="alert alert-primary d-flex align-items-center shadow-sm border-0 rounded-3 animate-fade-in-up"
                role="alert">
                <i class="bi bi-info-circle-fill fs-4 me-3 text-primary"></i>
                <div>{{ session('updated') }}</div>
            </div>
        @endif

        @if(session('deleted'))
            <div class="alert alert-danger d-flex align-items-center shadow-sm border-0 rounded-3 animate-fade-in-up"
                role="alert">
                <i class="bi bi-trash-fill fs-4 me-3 text-danger"></i>
                <div>{{ session('deleted') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center shadow-sm border-0 rounded-3 animate-fade-in-up"
                role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0 rounded-3 animate-fade-in-up">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="mt-auto py-4 text-center text-muted">
        <div class="container">
            <p class="mb-0 small">جميع الحقوق محفوظة &copy; {{ date('Y') }} مصروفاتي. تم التطوير بحب ❤️</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>