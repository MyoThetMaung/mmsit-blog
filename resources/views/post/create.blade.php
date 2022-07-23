@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('post.index') }}">Posts</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4>Create New Post</h4>
            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="title" class="form-label">Post Title</label>
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" >
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Select Category</label>
                        <select type="text" name="category" id="category"
                            class="form-select @error('category') is-invalid @enderror"
                            value="{{ old('category') }}" >
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == old('category') ? 'selected' : '' }}>{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Post Description</label>
                        <textarea type="text" name="description" id="description" rows="8"
                        class="form-control @error('description') is-invalid @enderror">
                             {{ old('description') }}
                        </textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <label for="featuredImage" class="form-label">Image</label>
                            <input type="file" name="featuredImage" id="featuredImage"
                                class="form-control @error('featuredImage') is-invalid @enderror" >
                            </input>
                            @error('featuredImage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn d-block btn-primary" type="submit" style="
                            height: 45px;
                            margin-top: 26px;">Create Post</button>
                    </div>
                </form>
        </div>
    </div>

@endsection
