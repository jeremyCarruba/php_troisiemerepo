@extends('layouts.app')

@section('page_title', 'Projet')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
<div class="row">
    <div class="card col-6" style="width: 18rem;">
        <img src="{{asset('medias/projet.png')}}" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">{{$project->name}}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{$project->user->first_name}} {{$project->user->last_name}}</h6>
            <p class="card-text">{{$project->description}}.</p>
            <h6 class="card-subtitle mb-2 text-muted">Total collecté: {{$amountCollected}} euros</h6>
            @auth
            <form action="/donation-create" method="POST" class="form-inline">
                @csrf
                <input type="hidden" name="project_id" value="{{$project->id}}">

                <div class="form-group mx-sm-3 mb-2">
                    <label for="amount" class="sr-only">Donation</label>
                    <input type="number" class="form-control" id="amount" name="amount" placeholder="donation amount"
                        required>
                </div>
                <button class="btn btn-primary" type="submit">Donne des sous</button>
            </form>
            @if ($isOwner)
            <a href="/project-edit/{{$project->id}}"><button class="btn btn-primary">Modifier ce projet</button></a>
            @endif
            @endauth
        </div>
    </div>


    <div class="col-6">
        <h2 style="font-size: 2rem;">Mes donations</h2>
        <ul>
            @foreach ($donations as $donation)
            @if($donation->user_id == Auth::id())

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Donation = {{$donation->amount / 100}} euros &nbsp
                        @if($donation->status ==0)
                        <span style="color:red;"> | En attente de paiement &nbsp</span>
                        <button class="btn btn-danger">t'as touché t'achètes</button>
                        @endif
                    </li>
                </ol>
            </nav>
            @endif
            @endforeach
        </ul>

    </div>
</div>
</div>
@endsection
