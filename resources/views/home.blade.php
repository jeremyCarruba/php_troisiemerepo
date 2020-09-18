@extends('layouts.app')

@section('page_title', 'Home')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection


@section('content')
        <a href="/project">
            <img src="{{asset('medias/projet.png')}}" style="height:500px !important; display: initial">
            {{-- <div class="overlay">Projets</div> --}}
        </a>
@endsection
