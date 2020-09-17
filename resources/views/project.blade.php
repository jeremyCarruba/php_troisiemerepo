@extends('layouts.app')

@section('page_title', 'Liste de projets')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')

@auth
<form action="/project-create" method="POST">
    @csrf
    <input type="text" name="name"><label for="name">Nom du projet</label>
    <textarea name="description"></textarea><label for="description">Description</label>
    <input type="submit" value="submit">
</form>
@endif

@foreach ($projects as $project)
<p><strong>Nom:</strong><a href="/project/{{$project->id}}">{{$project->name}}</a></p>
<p><strong>Description:</strong>{{$project->description}}</p>
<p><strong>Date</strong>{{$project->date}}</p>
<p><strong>Auteur</strong>{{$project->user->first_name}} {{$project->user->last_name}}</p>
@endforeach

@endsection
