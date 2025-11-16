<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Restaurant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .login-card {
            background: #fff;
            border: 1px solid #ccc;
            max-width: 400px;
            width: 100%;
        }

        .login-header {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #000;
        }

        .login-header h2 {
            font-size: 20px;
            margin: 10px 0 5px 0;
        }

        .login-header p {
            margin: 0;
            font-size: 13px;
        }

        .form-control {
            border: 1px solid #ccc;
            padding: 8px 12px;
            font-size: 13px;
        }

        .form-control:focus {
            border-color: #2c3e50;
            outline: none;
            box-shadow: none;
        }

        .form-label {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .btn-login {
            background: #2c3e50;
            border: none;
            padding: 10px;
            font-weight: bold;
            color: white;
            width: 100%;
            font-size: 14px;
        }

        .btn-login:hover {
            background: #1a252f;
            color: white;
        }

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            font-size: 12px;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        .footer-text {
            font-size: 11px;
            text-align: center;
            margin-top: 15px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card">
                    <div class="login-header">
                        <h2>RESTAURANT</h2>
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
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus 
                                       placeholder="Masukkan email">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       placeholder="Masukkan password">
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-login">
                                    Login
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>