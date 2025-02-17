<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Task Manager</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo-circle.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        .card {
            border: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .card-header {
            background-color: #26a69a;
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            padding: 20px;
        }

        .card-body {
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #26a69a;
            box-shadow: 0 0 5px rgba(38, 166, 154, 0.5);
        }

        .btn-primary {
            background-color: #26a69a;
            border: none;
            font-weight: 600;
            padding: 12px;
            border-radius: 0.5rem;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #00796b;
        }

        .form-check-label {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .text-danger {
            font-size: 0.875rem;
        }

        .card-footer {
            background-color: #f7f7f7;
            text-align: center;
            padding: 20px;
        }

        .card-footer a {
            color: #26a69a;
            text-decoration: none;
            font-weight: 600;
        }

        .card-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <img src="{{ asset('assets/img/logo-horizontal.png') }}" class="img-fluid" alt="task manager" style="max-width: 200px;">
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="admin@example.com" required autofocus>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Remember Me</label>
                        </div>
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <p>Developed by: <a href="https://github.com/mriahi635" target="_blank">Marouane RIAHI IDRISSI</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
