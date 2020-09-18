@extends('layouts.app')

@section('page_title', 'Donate')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')

@auth
<h1 style="font-size: 2rem; text-aling: center;">Vous avez donné {{($donation->amount)/100}} euros ! Merci !</h1>
<p><a href="/project">Retour à la page des projets</a></p>
@endif

@endsection
