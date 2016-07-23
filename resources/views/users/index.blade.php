@extends('layout.default')
@section('content')

    <h1>All Users</h1> 
    <p>{{ link_to_route('users.create', 'Add new user') }}</p> 
    @if ($users->count()) 
        <table class="table table-striped table-bordered"> 
        <thead> 
            <tr><th>Username</th> 
                <th>Password</th>
                <th>Created at</th>
                <th>Updated at</th>
                
            </tr>
        </thead>
        <tbody
            @foreach( $users as $user )          <!--for loop for each user-->
             <tr>
                <td>{{ $user->username }}</td>             <!--user[username]  to show user 1's username and so on-->
                <td>{{ $user->password }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
                <td>{{ link_to_route('users.edit', 'Edit',array($user->id), array('class' => 'btn btn-info')) }}</td>
                <td> {{ Form::open(array('method' => 'DELETE', 'route' => array('users.destroy', $user->id))) }} 
                     {{ Form::submit('Delete', array('class'=> 'btn btn-danger')) }} 
                     {{ Form::close() }}
                </td>   
             </tr>
            @endforeach 
        </tbody>
        </table>
        <center>{{ $users->links() }}</center>> 
    @else There are no users 
    @endif 
@stop