@extends('layouts.app')

@section('page_title', 'Éditer projet')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')

@auth
<form action="/project-edit/{{$project->id}}" method="POST">
    @csrf
    <input type="text" name="name" value="{{$project->name}}"><label for="name">Nom du projet</label>
    <textarea name="description">{{$project->description}}</textarea><label for="description">Description</label>
    <input type="submit" value="submit">
</form>
@endif

@endsection
