@extends('layouts.app')

@section('page_title', 'Liste de projets')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')

@auth
<form action="/project-create" method="POST" style="margin-left:150px; margin-right:150px;margin-bottom:20px;">
    @csrf
    <h2 style="font-size: 2rem; font-weight: bold">Ajout de projet:</h2>
    <div class="form-group">
        <label for="name">Nom du projet</label>
        <input type="text" name="name" class="form-control">
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endif

<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nom du projet</th>
        <th scope="col">Description</th>
        <th scope="col">Auteur</th>
      </tr>
    </thead>
    <tbody>

@foreach ($projects as $project)
<tr>
    <th scope="row">{{$project->id}}</th>
    <td><a href="/project/{{$project->id}}">{{$project->name}}</a></td>
    <td>{{$project->description}}</td>
    <td>{{$project->user->first_name}} {{$project->user->last_name}}</td>
</tr>

@endforeach
    </tbody>
</table>

@endsection
