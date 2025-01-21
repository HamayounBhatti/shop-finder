<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Urbansole Claim Utility' }}</title>
        <link rel="shortcut icon" href="{{asset('images/icons/urbansole_icon.png')}}" type="image/png">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
       <!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.27/dist/sweetalert2.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased background-image">
        <div class="min-h-screen" >
        <div class="container">
            @include('layouts.sidebar')
            <div class="main-content">
                @include('layouts.navigation')
                @if ($errors->any())
                    <div class="alert alert-danger mt-4" id="success-alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success mt-4" id="error-alert">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- Page Heading -->
                @yield('content')
            </div>
        </div>
            @include('layouts.footer')
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            
            <!-- Page Content -->
            <!--  -->
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.27/dist/sweetalert2.min.js"></script>

<script src="{{ asset('js/scripts/distribution/distribution-record-modal.js') }}"></script>
<script src="{{ asset('js/scripts/qa/invoice_image_modal.js') }}"></script>
<script src="{{ asset('js/scripts/claim/claim-settlement-form.js') }}"></script>
<script>
        $(document).ready(function() {
        // Fade out success alert after 5 seconds
        if ($('#success-alert').length) {
            setTimeout(function() {
                $('#success-alert').fadeOut();
            }, 5000);
        }

        // Fade out error alert after 5 seconds
        if ($('#error-alert').length) {
            setTimeout(function() {
                $('#error-alert').fadeOut();
            }, 5000);
        }
});
</script>
    </body>
</html>
