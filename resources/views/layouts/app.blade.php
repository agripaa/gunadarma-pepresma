<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Prestasi Mahasiswa Gunadarma</title>
    
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        
        <link rel="icon" href="{{ asset('images/logo-gundar.png') }}" type="image/x-icon">

        
        <style>
            section {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                scroll-snap-align: start;
                scroll-behavior: smooth;
            }
    
            html, body {
                height: 100%;
            }
    
        </style>
    
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
<body class="font-sans antialiased bg-white">
    <div class="min-h-screen bg-white">
        <nav class="bg-white shadow-lg fixed w-full z-50 top-0">
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 py-4 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center w-full justify-between">
                        <div class="flex-shrink-0">
                            <img class="h-16 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo">
                        </div>
                        <div class="hidden items-center space-x-8 sm:flex ml-10">
                            <a href="{{ url('/') }}" class="text-gray-900 text-lg font-medium hover:text-purple-600">Home</a>
                            <a href="#prestasi" class="text-gray-900 text-lg font-medium hover:text-purple-600">Prestasi</a>
                            <a href="#contact" class="text-gray-900 text-lg font-medium hover:text-purple-600">Contact</a>
                            <a href="{{ url('/login') }}" class="bg-purple-600 hover:bg-purple-700 duration-300 rounded-xl text-white font-semibold py-1 px-4">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="max-w-screen-2xl w-full mx-auto px-4 sm:px-6 py-4 lg:px-8">
            @yield('content')
        </main>
    </div>

    <!-- Footer Section -->
    <footer class="bg-purple-700 text-white pt-12 pb-2 mt-4">
        <div class="flex flex-col justify-between container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <!-- Logo -->
                <div class="mb-6 md:mb-0">
                    <img src="{{ asset('images/logo-gunadarma.png') }}" alt="Gunadarma University" class="w-48">
                </div>

                <!-- Dynamic Footer Titles and Items -->
                @foreach ($footers as $footer)
                    <div class="text-center mb-6 md:mb-0 md:text-left">
                        <h5 class="font-semibold mb-2">{{ $footer->title_footer }}</h5>
                        @foreach ($footer->listFooters as $listFooter)
                            <a href="{{ $listFooter->link ?? '#' }}" class="hover:underline">{{ $listFooter->name_list }}</a><br>
                        @endforeach
                    </div>
                @endforeach

                <!-- Contact Us in Footer -->
                <div class="text-center md:text-left">
                    <h5 class="font-semibold mb-2">Contact Us</h5>
                    <p><i class="fas fa-phone"></i> @if ($contact)<a href="tel:+62{{ $contact->no_telepon }}" class="hover:underline">{{ $contact->no_telepon }}</a>@else N/A @endif</p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $contact->alamat ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="text-center mt-10">
                <p class="text-xs font-medium">&copy; {{ now()->year }} Pepresma. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
