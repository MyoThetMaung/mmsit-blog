@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User</li>
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
            <h1>User List</h1><hr>
            <div class="d-flex justify-content-between my-3">
                <div>
                    @if(request('keyword'))
                        <p>Search By: "{{ request('keyword') }}" :&nbsp;
                        <a href="{{ route('user.index') }}"><i class="bi bi-trash"></i></a></p>

                    @endif
                </div>
                <form action="{{ route('user.index') }}" method="GET">
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Control</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                {{ $user->role }}
                            </td>
                            <td>
                                <a href="{{ route('user.show',$user->id) }}" class="btn btn-sm btn-success">
                                    View
                                </a>
                                {{--  can is used when authorized | using Gate  --}}
                                @can("update-user",$user)
                                    <a href="{{ route('user.edit',$user->id) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                @endcan
                                {{--  can is used when authorized | using Policy  --}}
                                @can("delete",$user)
                                    <form action="{{ route('user.destroy',$user->id) }}" method="user"
                                        class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endcan
                            </td>
                            <td class="text-black-50">{{ $user->created_at->format('d-m-Y | h:m A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="6">There is no user</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $users->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
