@extends('layouts.app')

@section('page_title', 'Projet')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="card" style="width: 18rem;">
    <img src="{{asset('medias/projet.png')}}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">{{$project->name}}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{$project->user->first_name}} {{$project->user->last_name}}</h6>
      <p class="card-text">{{$project->description}}.</p>
      @auth
      <form action="/donation-create" method="POST" class="form-inline">
        @csrf
        <input type="hidden" name="project_id" value="{{$project->id}}">

        <div class="form-group mx-sm-3 mb-2">
            <label for="amount" class="sr-only">Donation</label>
            <input type="number" class="form-control" id="amount" placeholder="donation amount" required>
          </div>
          <button class="btn btn-primary" type="submit">Donne des sous</button>
      </form>
      @if ($isOwner)
      <a href="/project-edit/{{$project->id}}"><button class="btn btn-primary">Modifier ce projet</button></a>
      @endif
      @endauth
    </div>
  </div>



@if ($isOwner)
<ul>
    @foreach ($donations as $donation)
        @if($donation->user_id == Auth::id())
            <li>{{$donation->user->first_name}} - Donation = {{$donation->amount}} euros</li>
        @endif
    @endforeach
</ul>

<a href="/project-edit/{{$project->id}}">Modifier ce projet</a>
@endif

@endsection
