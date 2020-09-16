@extends('layouts.app')

@section('page_title', 'Se connecter')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')
<form action="/profile-connect" method="POST">
<input type="email" name="email"><label for="email">Email</label>
<input type="password" name="password"><label for="password">Mot de passe</label>
<input type="submit">
</form>

<a href="/profile-create">Pas encore inscrit ?</a>

@endsection