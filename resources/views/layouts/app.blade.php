<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>EchoChat</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="EchoChat is a real-time messaging application." />
    <meta name="keywords" content="chat, messaging, real-time, Laravel, EchoChat" />
    <meta name="author" content="EchoChat" />
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#1f2937" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="format-detection" content="telephone=no" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap"
        rel="stylesheet">

    <!-- Vite CSS -->
    @vite(['resources/js/app.js'])

    <!-- Custom Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animations.css') }}" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f8fafc;
            color: #1f2937;
        }

        #mainContainer {
            background: white;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f3f4f6;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Sidebar Toggle */
        #sidebarToggle {
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                left: -100%;
                top: 70px;
                width: 280px;
                height: calc(100vh - 70px);
                z-index: 1040;
                transition: left 0.3s ease;
            }

            #sidebar.show {
                left: 0;
            }

            #chatContainer {
                width: 100%;
            }
        }
    </style>

    @stack('css')
</head>

<body>
    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Main Content -->
    <main class="py-0" style="height: 100%;">
        <div class="container-fluid h-100">
            <div class="row h-100" id="mainContainer">
                <!-- Sidebar: Conversations -->
                @includeWhen(request()->routeIs(['home', 'conversation.show']), 'layouts.sidebar')

                <!-- Chat Window -->
                <div class="col flex-grow-1 d-flex flex-column g-0" id="chatContainer" style="min-width: 0;">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>


    @stack('script')
</body>

</html>
