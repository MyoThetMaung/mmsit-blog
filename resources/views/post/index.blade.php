@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Post</li>
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
            <h1>Post List</h1><hr>
            <div class="d-flex justify-content-between my-3">
                <div>
                    @if(request('keyword'))
                        <p>Search By: "{{ request('keyword') }}" :&nbsp;
                        <a href="{{ route('post.index') }}"><i class="bi bi-trash"></i></a></p>

                    @endif
                </div>
                <form action="{{ route('post.index') }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" required>
                        <button class="btn btn-success" type="submit"> <i class="bi bi-search"></i> Search</button>
                    </div>
                </form>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        @notAuthor
                            <th>Owner</th>
                        @endnotAuthor
                        <th>Control</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>
                                {{ $post->title }}
                            </td>
                            <td>
                                {{ \App\Models\Category::find($post->category_id)->title }}
                            </td>
                            @notAuthor
                                <td>
                                    {{ \App\Models\User::find($post->user_id)->name }}
                                </td>
                            @endnotAuthor
                            <td>
                                <a href="{{ route('post.show',$post->id) }}" class="btn btn-sm btn-success">
                                    View
                                </a>
                                {{--  can is used when authorized | using Gate  --}}
                                @can("update",$post)
                                    <a href="{{ route('post.edit',$post->id) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                @endcan
                                {{--  can is used when authorized | using Policy  --}}
                                @can("delete",$post)
                                    <form action="{{ route('post.destroy',$post->id) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endcan
                            </td>
                            <td class="text-black-50">{{ $post->created_at->format('d-m-Y | h:m A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="6">There is no post</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $posts->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
