
<!doctype html>
<html>
<head>
    @include('projects.includes.Head')
</head>
<body>
<div class="content">
    

    <header class="row">
        @include('projects.includes.Header')
    </header>

    @if (Session::has('message'))
        <div class="flash alert-info">
            <p>{{ Session::get('message') }}</p>
        </div>
    @endif
    
    @if($errors->any())
        <div class='flash alert-danger'>
            @foreach ( $errors->all() as $error )
             <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    

    <div id="main" class="row">

            @yield('content')

    </div>

    <footer class="row">
        @include('projects.includes.Footer')
    </footer>

</div>
</body>
</html