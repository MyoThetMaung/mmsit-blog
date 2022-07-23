@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4>{{ $post->title }}</h4> <hr>
            <div>
                <span class="badge bg-secondary">
                    <i class="bi bi-grid"></i>
                    {{ \App\Models\Category::find($post->category_id)->title }}
                </span>
                <span class="badge bg-secondary">
                    <i class="bi bi-person"></i>
                    {{ \App\Models\User::find($post->user_id)->name }}
                </span>
                <span class="badge bg-secondary">
                    <i class="bi bi-calendar"></i>
                    {{ $post->created_at->format('d M Y') }}
                </span>
                <span class="badge bg-secondary">
                    <i class="bi bi-clock"></i>
                    {{ $post->created_at->format('h : m A') }}
                </span>
                @if(isset($post->featured_image))
                    <img src="{{ asset('storage/'.$post->featured_image) }}" class="w-100 mt-3 mb-2" alt="">
                @endif
                <p>
                    {{ $post->description }}
                </p> <hr>
                <div>
                    <a href="{{ route('post.create') }}" class="btn btn-success">Create Post</a>
                    <a href="{{ route('post.index') }}" class="btn btn-primary">All Post</a>
                </div>
            </div>
        </div>
    </div>

@endsection
