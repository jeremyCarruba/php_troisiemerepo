@extends('layouts.app')

@section('page_title', 'Projet')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')

<p>{{$project->name}}</p>
<p>{{$project->userCustom->first_name}}</p>

@endsection