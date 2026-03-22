<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Chat App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
     <link href="{{asset('css/style.css')}}" rel="stylesheet">
    @stack('css')
</head>
<body>
{{-- navbar --}}
@include('layouts.navbar')
<main class="py-0">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar: Contacts -->
            @includeWhen(request()->routeIs(['home']), 'layouts.sidebar')
            <!-- Chat Window -->
            @yield('content')
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{asset('js/scripts.js')}}"> </script>
@stack('script')
</body>
</html>
