@extends('layouts.app')

@section('page_title', 'Home')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection


@section('content')
<ul>
    <li>
        <a href="/profile">Se connecter</a>
    </li>
    <li>
        <a href="/project">Projets</a>
    </li>
</ul>
@endsection