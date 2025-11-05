<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Restaurant')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #6366f1;
            --secondary-color: #ec4899;
            --accent-color: #06b6d4;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            
            /* Gradient variations */
            --primary-gradient: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            --secondary-gradient: linear-gradient(135deg, var(--secondary-color) 0%, #be185d 100%);
            --accent-gradient: linear-gradient(135deg, var(--accent-color) 0%, #0891b2 100%);
            --success-gradient: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
            --danger-gradient: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
            --info-gradient: linear-gradient(135deg, var(--info-color) 0%, #2563eb 100%);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            min-height: 100vh;
            color: var(--gray-800);
        }

        /* SIDEBAR */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: var(--shadow-xl);
            position: fixed;
            backdrop-filter: blur(10px);
        }

        .sidebar h4 {
            font-weight: 700;
            margin-top: 1rem;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.9);
            border-radius: 15px;
            margin: 8px 12px;
            transition: all 0.4s ease;
            padding: 12px 18px;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .sidebar .nav-link:hover::before {
            left: 100%;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
            transform: translateX(8px);
            box-shadow: var(--shadow-md);
        }

        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.25);
            color: white;
            font-weight: 600;
            box-shadow: var(--shadow-md);
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 230px;
            background: transparent;
            min-height: 100vh;
            padding: 20px 40px;
            transition: all 0.3s;
        }

        /* NAVBAR TOP */
        .topbar {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            padding: 15px 25px;
            margin-bottom: 25px;
            backdrop-filter: blur(10px);
            border: 1px solid var(--gray-200);
        }

        .topbar .btn-outline-success {
            border-radius: 15px;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .topbar .btn-outline-success:hover {
            background: var(--primary-gradient);
            color: white;
            border: 2px solid transparent;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* CARD STYLE */
        .card {
            border: none;
            border-radius: 25px;
            box-shadow: var(--shadow-lg);
            transition: all 0.4s ease;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border: 1px solid var(--gray-200);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .card-header {
            background: var(--primary-gradient);
            color: white;
            font-weight: 600;
            border-radius: 25px 25px 0 0;
            padding: 20px 25px;
        }

        /* BUTTONS */
        .btn {
            border-radius: 15px;
            font-weight: 600;
            padding: 12px 25px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            text-transform: none;
            letter-spacing: 0.5px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-success {
            background: var(--success-gradient);
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: var(--success-color);
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-warning {
            background: var(--warning-gradient);
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background: var(--warning-color);
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-danger {
            background: var(--danger-gradient);
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: var(--danger-color);
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-info {
            background: var(--info-gradient);
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-info:hover {
            background: var(--info-color);
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--gray-600) 0%, var(--gray-700) 100%);
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: var(--gray-700);
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        /* Button Sizes */
        .btn-sm {
            padding: 8px 16px;
            font-size: 0.875rem;
            border-radius: 12px;
        }

        .btn-lg {
            padding: 16px 32px;
            font-size: 1.125rem;
            border-radius: 20px;
        }

        .btn-xl {
            padding: 20px 40px;
            font-size: 1.25rem;
            border-radius: 25px;
        }

        /* Button Groups */
        .btn-group .btn {
            margin-right: 5px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        /* Icon Buttons */
        .btn i {
            margin-right: 8px;
        }

        .btn i:only-child {
            margin-right: 0;
        }

        /* Outline Buttons */
        .btn-outline-primary {
            background: transparent;
            border: 2px solid #47c59c;
            color: #47c59c;
        }

        .btn-outline-primary:hover {
            background: var(--card-gradient);
            border-color: transparent;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(71, 197, 156, 0.4);
        }

        .btn-outline-success {
            background: transparent;
            border: 2px solid #56ab2f;
            color: #56ab2f;
        }

        .btn-outline-success:hover {
            background: var(--success-gradient);
            border-color: transparent;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(168, 224, 99, 0.4);
        }

        .btn-outline-danger {
            background: transparent;
            border: 2px solid #f6416c;
            color: #f6416c;
        }

        .btn-outline-danger:hover {
            background: var(--danger-gradient);
            border-color: transparent;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(246, 65, 108, 0.4);
        }

        .btn-outline-warning {
            background: transparent;
            border: 2px solid #fdcb6e;
            color: #fdcb6e;
        }

        .btn-outline-warning:hover {
            background: var(--warning-gradient);
            border-color: transparent;
            color: #4d4d4d;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(253, 203, 110, 0.4);
        }

        /* Special Buttons */
        .btn-float {
            border-radius: 50%;
            width: 60px;
            height: 60px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-float:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        .btn-block {
            width: 100%;
            display: block;
        }

        /* Button States */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn:disabled:hover {
            transform: none !important;
            box-shadow: none !important;
        }

        /* Form Buttons */
        .btn-group-vertical .btn {
            margin-bottom: 5px;
        }

        .btn-group-vertical .btn:last-child {
            margin-bottom: 0;
        }

        /* Action Buttons */
        .btn-action {
            min-width: 120px;
            text-align: center;
        }

        .btn-action i {
            display: block;
            margin-bottom: 5px;
            font-size: 1.2em;
        }

        /* Quick Action Buttons */
        .btn-quick {
            padding: 20px;
            text-align: center;
            border-radius: 20px;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .btn-quick i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .btn-quick span {
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* TABLES */
        .table {
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(14, 165, 233, 0.1);
        }

        .table th {
            background: #eef2ff; /* light indigo tint */
            color: #111827; /* dark text */
            font-weight: 700;
            padding: 15px;
        }

        /* Ensure any dark-themed table headers remain readable */
        .table-dark th,
        .table thead.table-dark th {
            background-color: #e5e7eb !important; /* gray-200 */
            color: #111827 !important; /* gray-900 */
        }

        .table td {
            padding: 15px;
            color: #111827; /* dark text for cells */
            border-bottom: 1px solid #e5e7eb; /* gray-200 */
        }

        .table tbody tr:hover {
            background: rgba(14, 165, 233, 0.05);
        }

        /* ALERTS */
        .alert-success {
            background: var(--success-gradient);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
            box-shadow: 0 4px 15px rgba(168, 224, 99, 0.3);
        }

        .alert-danger {
            background: var(--danger-gradient);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
            box-shadow: 0 4px 15px rgba(246, 65, 108, 0.3);
        }

        .alert-warning {
            background: var(--warning-gradient);
            color: #4d4d4d;
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
            box-shadow: 0 4px 15px rgba(253, 203, 110, 0.3);
        }

        .alert-info {
            background: var(--info-gradient);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
            box-shadow: 0 4px 15px rgba(116, 185, 255, 0.3);
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            .sidebar {
                position: relative;
                min-height: auto;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- SIDEBAR -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="text-center p-3">
                    <i class="fas fa-leaf fa-2x mb-3"></i>
                    <h4>Restaurant</h4>
                    <hr style="border-color: rgba(255,255,255,0.3);">
                </div>

                <ul class="nav flex-column px-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-2"></i>Dashboard
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin() || auth()->user()->isWaiter())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('menu.*') ? 'active' : '' }}" href="{{ route('menu.index') }}">
                            <i class="fas fa-utensils me-2"></i>Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">
                            <i class="fas fa-user-friends me-2"></i>Pelanggan
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->isWaiter())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pesanan.*') ? 'active' : '' }}" href="{{ route('pesanan.index') }}">
                            <i class="fas fa-clipboard-list me-2"></i>Pesanan
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->isCashier())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                            <i class="fas fa-credit-card me-2"></i>Transaksi
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('meja.*') ? 'active' : '' }}" href="{{ route('meja.index') }}">
                            <i class="fas fa-chair me-2"></i>Meja
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->isWaiter() || auth()->user()->isCashier() || auth()->user()->isOwner())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                            <i class="fas fa-chart-line me-2"></i>Laporan
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>

            <!-- MAIN CONTENT -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <div class="topbar d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold text-success mb-0">@yield('page-title', 'Dashboard')</h4>
                    <div class="dropdown">
                        <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i> {{ auth()->user()->name }}
                            <span class="badge bg-success ms-2">{{ ucfirst(auth()->user()->role) }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-times me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html>
