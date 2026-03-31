<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Chat App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @vite(['resources/js/app.js'])
    @stack('css')
</head>

<body>
    {{-- navbar --}}
    @include('layouts.navbar')
    <main class="py-0" style="height: 100%;">
        <div class="container-fluid h-100">
            <div class="row h-100" id="mainContainer">
                <!-- Sidebar: Contacts -->
                @includeWhen(request()->routeIs(['home', 'conversation.show']), 'layouts.sidebar')
                <!-- Chat Window -->
                <div class="col flex-grow-1 d-flex flex-column g-0" id="chatContainer" style="min-width: 0;">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    @stack('script')
</body>

</html>
