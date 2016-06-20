
<!doctype html>
<html>
<head>
    @include('tasks.includes.Head')
</head>
<body>
<div class="container">

    <header class="row">
        @include('tasks.includes.Header')
    </header>

    <div id="main" class="row">

            @yield('content')

    </div>

    <footer class="row">
        @include('tasks.includes.Footer')
    </footer>

</div>
</body>
</html