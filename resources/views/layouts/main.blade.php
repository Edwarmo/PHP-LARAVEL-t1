<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller PHP Avanzado - 2026-1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-code text-2xl"></i>
                    <span class="text-xl font-bold">Taller PHP Avanzado - 2026-1</span>
                </div>
                <div class="hidden md:flex space-x-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('home') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-home mr-2"></i>Inicio
                    </a>
                    <a href="{{ route('students.index') }}" class="px-4 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('students.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-user-graduate mr-2"></i>Estudiantes
                    </a>
                    <a href="{{ route('shippings.index') }}" class="px-4 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('shippings.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-shipping-fast mr-2"></i>Envíos
                    </a>
                    <a href="{{ route('finance.index') }}" class="px-4 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('finance.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-calculator mr-2"></i>Finanzas
                    </a>
                    <a href="{{ route('payroll.index') }}" class="px-4 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('payroll.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-money-bill-wave mr-2"></i>Nómina
                    </a>
                    <a href="{{ route('profile.create') }}" class="px-4 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('profile.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-user-circle mr-2"></i>Perfil
                    </a>
                </div>
                <!-- Mobile menu button -->
                <button id="mobile-menu-btn" class="md:hidden px-4 py-2">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <a href="{{ route('home') }}" class="block px-4 py-2 hover:bg-blue-700">Inicio</a>
            <a href="{{ route('students.index') }}" class="block px-4 py-2 hover:bg-blue-700">Estudiantes</a>
            <a href="{{ route('shippings.index') }}" class="block px-4 py-2 hover:bg-blue-700">Envíos</a>
            <a href="{{ route('finance.index') }}" class="block px-4 py-2 hover:bg-blue-700">Finanzas</a>
            <a href="{{ route('payroll.index') }}" class="block px-4 py-2 hover:bg-blue-700">Nómina</a>
            <a href="{{ route('profile.create') }}" class="block px-4 py-2 hover:bg-blue-700">Perfil</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400">
                <i class="fas fa-user-graduate mr-2"></i>
                Taller PHP Avanzado - 2026-1 | Cristian Camilo Echeverri Giraldo
            </p>
            <p class="text-gray-500 text-sm mt-2">
                Laravel {{ app()->version() }} & PHP {{ PHP_VERSION }}
            </p>
        </div>
    </footer>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
