<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href={{asset('css/bootstrap.min.css')}}>
    <title>login</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-form {
            max-width: 450px;
            margin: 80px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-weight: 600;
            text-align: center;
            margin-bottom: 25px;
        }

        .btn-login {
            width: 100%;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-form">
        <h4 class="form-title">Login</h4>
        <form action="{{route('login.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                       placeholder="name@example.com" name="email">
                @error('email')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                       placeholder="********" name="password">
                @error('password')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-login">Login</button>
            <a href="{{route('register')}}" class="register-link">Don't have an account? Create one</a>
        </form>
    </div>
</div>
<script src={{asset('js/bootstrap.bundle.min.js')}}></script>
</body>
</html>
