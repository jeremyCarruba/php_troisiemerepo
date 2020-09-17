@extends('layouts.app')

@section('page_title', 'Projet')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')

<p>{{$project->name}}</p>
<p>{{$project->description}}</p>
<p>{{$project->user->first_name}}</p>
<p>{{$project->user->last_name}}</p>

@if ($isOwner)
<a href="/project-edit/{{$project->id}}">Modifier ce projet</a>
@endif

@endsection
