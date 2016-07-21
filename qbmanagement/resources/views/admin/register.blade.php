<!DOCTYPE html>
<html>
    <head>
    <!-- Latest compiled and minified CSS -->
    
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <link rel="stylesheet" href="/css/sol.css">
      <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

        <style type="text/css">
          body{
              font-family: Open Sans;
              margin-bottom: 100px;
          }
          .math_keyboard{
            width:auto;
            margin-right: 4px;
            height: auto;
            margin-top: 10px;
            }

            .taglist{
            list-style-type: none;
            padding: 10px;
            }

            .tagitem, button{
            display: inline-block;
            border-style: solid;
            border-width: 1.5px;
            border-color:  #0066ff;
            background-color: #f2f2f2;
            color:#1a1a1a;
            margin-bottom: 4px;
            padding: 2px;
            border-radius: 4px;
            font-size: small;
            }

            .question_title{
              font-size: 15px;
            }

            .image_list{
              list-style-type: none;
            }

            .image_list li{
              display:block;
              padding: 7px;
            }

            .image_list li img{
              max-height: 350px;
            max-width: 600px;
            }

            .creators{
              font-size: 10px;
              color:#3377ff;
              font-style: italic;
              margin-left: 10px;
              padding-bottom: 15px;
           }

            .creators ul{
              list-style-type: none;
              float:right;
            }

            .creators li{
              display: inline-block;
              padding-right: 20px;
            }

            .q_header{
              font-size: 12px;
              color: grey;
              font-style: italic;
              margin-left: 10px;
              padding-bottom: 20px;
            }

            .q_header ul{
        list-style-type: none;
        float:right;
        }

       .q_header li{
        display: inline-block;
        padding-right: 20px;
        }

        .level_and_time{
        font-style: bold;
        color:#3377ff;
        }

        .options{
        font-size: 15px;
        }

        .options ol{
        list-style-type: lower-alpha;
        }

        .options li{
        display: block;
        }

        .results{
        font-style : italic;
        color : #8c8c8c;
        font-size: 16px;
        padding-bottom: 20px;
        }

        .actions_buttons {
        font-size: 10px;
        padding-bottom: 0px;
        }

        .actions_buttons ul{
        list-style-type: none;
        float:right;
        }

        .actions_buttons li{
        display: inline-block;
        }

        .indent_left{
        margin-left: 14px;
        height: 100px;
        }
</style><title>Register</title>

<body>
    
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="/adminhome">{{ Auth::user()->name }}</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> logout</a></li>
        </ul>
      </div>
    </nav></br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register a New User</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">UserName</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}">

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>



