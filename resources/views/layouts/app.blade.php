<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teszt Feladat</title>
</head>
<body>
    
    <div class="container mb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function(){
                    $('.alert').alert('close');
                }, 3000);
            </script>
        @endif
        
        @yield('content')
    </div>

</body>

</html>
