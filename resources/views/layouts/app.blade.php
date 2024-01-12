<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zengo - Teszt Feladat</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>
   <!-- Navbar (Header) -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Zengo - Teszt Feladat - Gergi Péter</a>
        </div>
    </nav>

    <!-- Content Area -->
    <div class="container mt-3 flex-grow-1">   
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light fixed-bottom">
        <div class="container">
            <span class="text-muted"><?= date('Y-m-d') ?></span>
        </div>
    </footer>
</body>
</html>
