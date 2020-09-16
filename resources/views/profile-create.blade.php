@extends('layouts.app')

@section('page_title', 'Inscription')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')
<form action="/profile-new" method="POST">
<input type="text" name="first_name"><label for="first_name">Prénom</label>
<input type="text" name="last_name"><label for="last_name">Nom</label>
<input type="email" name="email"><label for="email">Email</label>
<input type="password"><label for="password">Mot de passe</label>
<input type="submit">
</form>

@endsection