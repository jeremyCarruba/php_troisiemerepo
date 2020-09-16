@extends('layouts.app')

@section('page_title', 'Liste de projets')
@section('css')
<link href="{{asset('css/style_home.css') }}" rel="stylesheet">
@endsection

@section('content')

@foreach ($projects as $project)
<p>{{$project->name}}</p>
@endforeach

@endsection