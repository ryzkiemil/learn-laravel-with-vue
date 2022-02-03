@extends('layouts.main')

@section('content')
  
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users</h1>
    </div>

    <div class="row">
        <div class="card mx-auto">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <form method="GET" action="{{ route('users.index') }}">
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <input type="search" name="search" id="inlineFormInput" class="form-control mb-2" placeholder="type here">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <a href="{{ route('users.create') }}" class="btn btn-primary mb-2">Create</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="col-{breakpoint}-auto">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="btn-group" aria-label="Basic example">
                                        <a type="button" href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                                        <form onclick="return confirm('Are you sure to delete this user?')" method="POST" action="{{ route('users.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection