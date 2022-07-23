@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('category.index') }}">Post</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Post</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4>Edit Post</h4>
            <form action="{{ route('post.update',$post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="mb-3">
                        <label for="title" class="form-label">Post Title</label>
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title',$post->title) }}" >
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Select Category</label>
                        <select type="text" name="category" id="category"
                            class="form-select @error('category') is-invalid @enderror"
                            value="{{ old('category',$post->category_id) }}" >
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" {{ $category->id == old('category',$post->category_id) ? 'selected' : '' }}>{{ $category->title }}</option>
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
                             {{ old('description',$post->description) }}
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
                            margin-top: 26px;">Update Post</button>
                    </div>
                    @isset($post->featured_image)
                        <img src="{{ asset('storage/'.$post->featured_image) }}" class="w-100 mt-4" alt=""> 
                    @endisset
                </form>
        </div>
    </div>
@endsection



    



