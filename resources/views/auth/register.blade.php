<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href={{asset('css/bootstrap.min.css')}}>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .register-form {
            max-width: 500px;
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

        .btn-register {
            width: 100%;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="register-form">
        <h4 class="form-title">Create Account</h4>
        <form action="{{route('register.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                       placeholder="John Doe" value="{{old('name')}}" name="name">
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       placeholder="name@example.com"
                       value="{{old('email')}}">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                       placeholder="********" name="password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                       id="password_confirmation"
                       placeholder="********"
                       name="password_confirmation">
                @error('password_confirmation')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-success btn-register">Register</button>
            <a href="{{route('login')}}" class="login-link">Already have an account? Login here</a>
        </form>
    </div>
</div>
<script src={{asset('js/bootstrap.bundle.min.js')}}></script>
</body>
</html>
