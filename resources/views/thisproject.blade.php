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
                <h6 class="card-subtitle mb-2 text-muted">{{$project->user->first_name}} {{$project->user->last_name}}
                </h6>
                <p class="card-text">{{$project->description}}.</p>
                <h6 class="card-subtitle mb-2 text-muted">Total collecté: {{$amountCollected}} euros</h6>
                @auth
                <form action="/donation-create" method="POST" class="form-inline">
                    @csrf
                    <input type="hidden" name="project_id" value="{{$project->id}}">

                    <div class="form-group mx-sm-3 mb-2">
                        <label for="amount" class="sr-only">Donation</label>
                        <input type="number" class="form-control" id="amount" name="amount"
                            placeholder="donation amount" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Donne des sous</button>
                </form>
                @if ($isOwner)
                <a href="/project-edit/{{$project->id}}"><button class="btn btn-primary">Modifier ce projet</button></a>
                @endif
                @endauth
            </div>
        </div>

        @auth
        <div class="col-6">
            <h2 style="font-size: 2rem;">Mes donations</h2>
            <ul>
                @error('hasPaid')
                    <h1>Merci d'avoir payé frère</h1>
                @enderror
                @foreach ($donations as $donation)
                @if($donation->user_id == Auth::id())

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Donation = {{$donation->amount / 100}}
                            euros &nbsp
                            @if($donation->status ==0)
                            <span style="color:red;"> | En attente de paiement (à payer: {{$donation->amount - $donation->amountPaid}})&nbsp</span>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#staticBackdrop">
                                t'as touché t'achètes
                            </button>

                            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Paiement</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Vous souhaitez effectuer un paiement ? Combien voulez vous donner ?
                                            <form action="/paiement" method="POST">
                                                @csrf
                                                <input type="hidden" name="donation_id" value="{{$donation->id}}">
                                                <label for="paymentAmount">Paiement (à payer: {{$donation->amount - $donation->amountPaid}})</label>
                                                <input name="amount" type="number" min="100" max="{{$donation->amount - $donation->amountPaid}}" required placeholder="{{$donation->amount - $donation->amountPaid}}">
                                                <button type="submit" class="btn btn-primary">Payer</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            Payé !
                            @endif

                        </li>
                    </ol>
                </nav>
                @endif
                @endforeach
            </ul>

        </div>
        @endauth
    </div>
</div>
@endsection
