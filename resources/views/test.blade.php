@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Library</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            San Kyi Tar
        </div>
    </div>
@endsection
