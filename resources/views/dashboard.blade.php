@extends('layouts.app')

@section('page_title', 'DASHBOARD!!!')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection


@section('content')
<h1>Hello {{$user->first_name}}</h1>
<ul>
    <a href="/logout"><li>Logging out</li></a>
    <a href="/profile-edit"><li>Changing contact informations</li></a>
</ul>
@endsection
