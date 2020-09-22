@extends('layouts.app')

@section('page_title', 'Donate')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')

@auth
<h1 style="font-size: 2rem; text-aling: center;">Vous avez donné {{$summary['donation']/100}} euros ! Comme des bastardos
nous prélevons {{$summary['fixedAndCommission'] / 100}} euros donc les gars du projets se retrouvent juste avec
{{$summary['amountCollected'] / 100 }} euros mdrrr Merci !</h1>
<p><a href="/project">Retour à la page des projets</a></p>
@endif

@endsection
