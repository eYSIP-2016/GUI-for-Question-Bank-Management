<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <link href="/css/GUI_QBank/home_page.css" rel="stylesheet" type="text/css">
       


    </head>
    <body>
    <div id="layout" class="pure-g">
        <div class="sidebar pure-u-1">
            <div class="header">
                <h1 class="brand-title">Sign In</h1><br>
                <!--form-->
                {!! Form::open(array('class' => 'form-inline', 'method' => 'POST', 'route' => array('credentials')  )) !!}

                    {!! Form::label('uname', 'Username') !!} <br>
                    {!! Form::text('uname', Input::old('uname'), array('placeholder' => 'Enter Username')) !!}<br>

                    {!! Form::label('password', 'Password') !!}<br>
                    {{ Form::password('password' ,array('placeholder' => 'Enter Password')) }}<br>
                    
                    {!! Form::submit('Sign In', array('class' => 'btn btn-danger')) !!}
                    {!! Form::close() !!}
            </div>
        </div>
    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="appname">
            <h1>
                GUI for<br>
                Question bank <br> 
                management
            </h1>
    </div>
    <div class="post_title">
        <i>An e-Yantra Project by Tushar and Bhalchandra</i>
    </div>
    </body>
</html>





 
