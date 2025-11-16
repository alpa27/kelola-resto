<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Restaurant')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">


    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial;
            background: #fff;
        }

        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            border-right: 1px solid #000;
            position: fixed;
            width: 180px;
        }

        .sidebar h4 {
            padding: 10px;
            border-bottom: 1px solid #34495e;
            font-size: 14px;
            color: #fff;
        }

        .sidebar a {
            display: block;
            padding: 8px 10px;
            color: #ecf0f1;
            text-decoration: none;
            border-bottom: 1px solid #34495e;
            font-size: 12px;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        .sidebar a.active {
            background: #3498db;
            color: #fff;
        }

        .main-content {
            margin-left: 180px;
            padding: 15px;
        }

        .topbar {
            background: #3498db;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            color: #fff;
        }

        .topbar h4 {
            font-size: 16px;
            display: inline-block;
            margin: 0;
            color: #fff;
        }

        .topbar .user {
            float: right;
            font-size: 12px;
            color: #fff;
        }

        .topbar .btn {
            padding: 4px 10px;
            font-size: 12px;
            background: #e74c3c;
            border: none;
            color: #fff;
        }

        .card {
            border: 1px solid #000;
            margin-bottom: 15px;
        }

        .card-header {
            background: #fff;
            padding: 8px;
            border-bottom: 1px solid #000;
            font-weight: bold;
            font-size: 13px;
        }

        .card-body {
            padding: 10px;
        }

        .btn {
            padding: 6px 12px;
            font-size: 12px;
            border: none;
            cursor: pointer;
            color: #fff;
            text-decoration: none;
            display: inline-block;
            margin-right: 5px;
            margin-bottom: 5px;
            font-family: Arial, sans-serif;
        }

        .btn-primary { 
            background: #007bff;
            color: #fff;
        }
        
        .btn-success { 
            background: #28a745;
            color: #fff;
        }
        
        .btn-warning { 
            background: #ffc107; 
            color: #000;
        }
        
        .btn-danger { 
            background: #dc3545;
            color: #fff;
        }

        .btn-info { 
            background: #17a2b8;
            color: #fff;
        }

        .btn-secondary { 
            background: #6c757d;
            color: #fff;
        }

        /* Khusus untuk button di table */
        .table .btn {
            padding: 5px 12px;
            font-size: 11px;
            min-width: 60px;
            text-align: center;
            font-weight: normal;
        }
        
        .table .btn-sm {
            padding: 4px 10px;
            font-size: 11px;
            min-width: 60px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        .table th, .table td {
            padding: 8px;
            font-size: 12px;
            text-align: left;
            color: #000;
        }

        .table th {
            background: #f5f5f5;
            font-weight: bold;
            color: #000;
            border-bottom: 2px solid #ddd;
        }

        .table td {
            background: #fff;
            color: #000;
        }
        
        .table tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }
        
        .table tbody tr:last-child {
            border-bottom: none;
        }

        .alert {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #000;
            font-size: 12px;
            background: #fff;
        }

        .alert-success { border-color: #000; }
        .alert-danger { border-color: #000; }

        .badge {
            background: #000;
            color: #fff;
            padding: 2px 5px;
            font-size: 10px;
        }

        @media (max-width: 768px) {
            .sidebar { position: relative; width: 100%; min-height: auto; }
            .main-content { margin-left: 0; }
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="sidebar">
        <h4>RESTAURANT</h4>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        
        @if(auth()->user()->isAdmin() || auth()->user()->isWaiter())
        <a href="{{ route('menu.index') }}" class="{{ request()->routeIs('menu.*') ? 'active' : '' }}">Menu</a>
        <a href="{{ route('pelanggan.index') }}" class="{{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">Pelanggan</a>
        @endif

        @if(auth()->user()->isWaiter())
        <a href="{{ route('pesanan.index') }}" class="{{ request()->routeIs('pesanan.*') ? 'active' : '' }}">Pesanan</a>
        @endif

        @if(auth()->user()->isCashier())
        <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}">Transaksi</a>
        @endif

        @if(auth()->user()->isAdmin())
        <a href="{{ route('meja.index') }}" class="{{ request()->routeIs('meja.*') ? 'active' : '' }}">Meja</a>
        @endif

        @if(auth()->user()->isWaiter() || auth()->user()->isCashier() || auth()->user()->isOwner())
        <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.)*' ? 'active' : '' }}">Laporan</a>
        @endif
    </div>

    <div class="main-content">
        <div class="topbar">
            <h4>@yield('page-title', 'Dashboard')</h4>
            <div class="user">
                {{ auth()->user()->name }} 
                <span class="badge">{{ ucfirst(auth()->user()->role) }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn">Logout</button>
                </form>
            </div>
            <div style="clear:both;"></div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html> 