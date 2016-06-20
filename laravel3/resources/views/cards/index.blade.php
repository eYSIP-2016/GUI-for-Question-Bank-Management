@extends('pages.layout')

@section('content')
@foreach($cards as $card)
 	<h1>{{$card->title}}</h1>
@endforeach
@stop