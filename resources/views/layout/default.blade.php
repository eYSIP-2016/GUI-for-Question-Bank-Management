<!doctype html>
<html>
<head>
     @include('layout.Head')
</head>


<body>
<div class="content">
    

    <header class="row">
        
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
    
 <center>
    <div id="main" class="row">
       
            @yield('content')
        
    </div>
</center>
    <footer class="row">
        @include('layout.Header')
        @include('layout.Footer')
    </footer>

</div>
</body>
</html>