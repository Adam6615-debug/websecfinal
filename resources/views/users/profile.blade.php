@extends('layouts.master')
@section('title', 'User Profile')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">User Profile</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Roles</th>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>Permissions</th>
                        <td>
                            @foreach($permissions as $permission)
                                <span class="badge bg-success">{{ $permission->display_name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    @if(auth()->user()->hasPermissionTo('admin_users') || auth()->id() == $user->id)
                        <a class="btn btn-sm btn-primary" href="{{ route('edit_password', $user->id) }}">Change Password</a>
                    @endif

                    @if(auth()->user()->hasPermissionTo('edit_users') || auth()->id() == $user->id)
                        <a href="{{ route('users_edit', $user->id) }}" class="btn btn-success">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
