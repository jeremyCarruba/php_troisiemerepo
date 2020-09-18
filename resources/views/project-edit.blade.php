@extends('layouts.app')

@section('page_title', 'Éditer projet')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')

@auth

<form action="/project-edit/{{$project->id}}" method="POST" style="margin-left:150px; margin-right:150px;margin-bottom:20px;">
    @csrf
    <h2 style="font-size: 2rem; font-weight: bold">Edition de projet:</h2>
    <div class="form-group">
        <label for="name">Nom du projet</label>
        <input type="text" name="name" class="form-control" value="{{$project->name}}">
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control">{{$project->description}}</textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endif

@endsection
