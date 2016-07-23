@extends('admin.adminhome')

	@section('users')
    <h1><i>Users</i></h1></br></br>


    <head><h4><legend>Add Users</legend></h4></head>
    <div class="panel panel-default">
                <div class="panel-heading">Register a New User</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('auth/register/') }}">
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
                            <div class="col-md-5 col-md-offset-5">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Add User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div></br></br></br></br>
        </div>


<head><h4><legend>View or Delete</legend></h4></head>
    
		@if ($users->count())
        </div>


        <table class="table table-striped table-bordered table-hover tablecondensed"> 
        <thead> 
            <tr><th>Name</th> 
                <th>Username</th>
                <th>E-Mail</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Remove</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach( $users as $user )          <!--for loop for each user-->
                @if( $user->user_type_id === 0)
                    <tr class="table-row" data-href="{{ URL::to('adminhome')}}">
                        <td>{{ $user->name }}</td>          <!--user[username]  to show user 1's username and so on-->
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td> {{ Form::open(array('method' => 'DELETE', 'route' => array('users.destroy', $user->id))) }} 
                        {{ Form::submit('Delete', array('class'=> 'btn btn-secondary')) }} 
                        {{ Form::close() }}
                        </td>   
                    </tr>
                @endif
            @endforeach 
        </tbody>
        </table>
        <center>{{ $users->links() }}</center> 
@else There are no users 
@endif 

@stop