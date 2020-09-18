@extends('layouts.app')

@section('page_title', 'Donate')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')

@auth
<h1>Vous avez donné {{$donation->amount}}</h1>
@endif

@endsection
