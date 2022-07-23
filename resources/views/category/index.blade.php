@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Category</li>
        </ol>
    </nav>

    <div class="card">
        @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('status') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        <div class="card-body">
            <h1>Category List</h1>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        @admin
                            <th>Owner</th>
                        @endadmin
                        <th>Control</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                {{ $category->title }} <br>
                                <span class="badge bg-success">{{ $category->slug }}</span>
                            </td>
                            @admin
                                <td>
                                    {{ App\Models\User::find($category->user_id)->name }}
                                </td>
                            @endadmin
                            <td>
                                @can('update',$category)
                                    <a href="{{ route('category.edit',$category->id) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                @endcan
                                @can('delete',$category)
                                    <form action="{{ route('category.destroy',$category->id) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endcan
                            </td>
                            <td class="text-black-50">{{ $category->created_at->format('d-m-Y | h:m A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
