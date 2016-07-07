@extends('layouts.app')

@section('content')

@if ($users->count()) 
        <table class="table table-striped table-bordered"> 
        <thead> 
            <tr><th>Name</th> 
                <th>Username</th>
                <th>E-Mail</th>
                <th>Created at</th>
                <th>Updated at</th>
                
            </tr>
        </thead>
        <tbody
            @foreach( $users as $user )          <!--for loop for each user-->
                @if( $user->user_type_id === 0)
                    <tr>
                        <td>{{ $user->name }}</td>          <!--user[username]  to show user 1's username and so on-->
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>{{ link_to_route('users.edit', 'Edit',array($user->id), array('class' => 'btn btn-info')) }}</td>
                        <td> {{ Form::open(array('method' => 'DELETE', 'route' => array('users.destroy', $user->id))) }} 
                        {{ Form::submit('Delete', array('class'=> 'btn btn-danger')) }} 
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
<center>
	{{ link_to('register', 'Add User',array('class' => 'btn btn-info') ,$secure =null) }}
</center>
@stop