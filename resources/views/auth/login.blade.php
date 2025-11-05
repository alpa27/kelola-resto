<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Restaurant</title>

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
        }

        body {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(79, 70, 229, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(99, 102, 241, 0.2) 0%, transparent 50%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 30px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            transition: all 0.4s ease;
            backdrop-filter: blur(20px);
            border: 1px solid var(--gray-200);
            position: relative;
            z-index: 1;
        }

        .login-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            text-align: center;
            padding: 2.5rem;
            border-bottom: 3px solid var(--primary-light);
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }

        .login-header h2 {
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 0.3rem;
            position: relative;
            z-index: 1;
        }

        .login-header p {
            margin: 0;
            font-size: 0.95rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .form-control {
            border-radius: 15px;
            border: 2px solid #e0f2ef;
            padding: 15px 20px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .form-control:focus {
            border-color: #2196f3;
            box-shadow: 0 0 0 0.25rem rgba(33, 150, 243, 0.25);
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 20px;
            padding: 15px 35px;
            font-weight: bold;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            color: white;
            position: relative;
            overflow: hidden;
            text-transform: none;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            background: linear-gradient(135deg, var(--primary-dark) 0%, #312e81 100%);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login:focus {
            box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.25);
        }

        .input-group-text {
            background: rgba(224, 242, 254, 0.9);
            border: 2px solid #e0f2fe;
            border-right: none;
            border-radius: 15px 0 0 15px;
            color: #2196f3;
            backdrop-filter: blur(10px);
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 15px 15px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--primary-color);
            background: rgba(79, 70, 229, 0.1);
        }

        /* Role Badges */
        .role-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
            margin: 3px;
        }

        .role-admin { background: var(--danger-color); color: white; }
        .role-waiter { background: var(--success-color); color: white; }
        .role-kasir { background: var(--warning-color); color: white; }
        .role-owner { background: var(--primary-color); color: white; }

        .alert-danger {
            border-radius: 15px;
            background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
            border: none;
            color: white;
            padding: 15px 20px;
            box-shadow: var(--shadow-md);
        }

        .footer-text {
            font-size: 0.85rem;
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }

        /* Animation */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container fade-in">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card login-card">
                    <div class="login-header">
                        <i class="fas fa-leaf fa-3x mb-3"></i>
                        <h2>Restaurant</h2>
                        <p>Sistem Kasir Restoran</p>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required autofocus 
                                           placeholder="Masukkan email anda">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required 
                                           placeholder="Masukkan password">
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-login">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </button>
                            </div>
                        </form>

                        <!-- <div class="mt-4 text-center">
                            <h6 class="mb-2 fw-semibold">Akun Role:</h6>
                            <div>
                                <span class="role-badge role-admin">Admin</span>
                                <span class="role-badge role-waiter">Waiter</span>
                                <span class="role-badge role-kasir">Kasir</span>
                                <span class="role-badge role-owner">Owner</span>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Gunakan email seperti: <b>admin@restaurant.com</b>, dll.
                            </small>
                        </div> -->

                        <div class="footer-text mt-4">
                            &copy; {{ date('Y') }} Restaurant Management | Design by RPL🌿
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
