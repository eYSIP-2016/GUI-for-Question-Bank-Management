@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome {{ Auth::user()->name }}</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6" >
                            <h3></h3>
                        </div>
                        @if ( Auth::user()->user_type_id == 1 )
                            <div class="col-md-6">   
                                <h3>{!! link_to_route('users.index', 'Users', null, array('class' => 'btn btn-danger')) !!} </h3>
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

