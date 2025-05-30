@extends('layouts.master')
@section('title', 'User Profile')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card bg-dark text-light border-0 shadow-lg">
            <div class="card-header bg-black border-bottom border-secondary">
                <h5 class="mb-0 text-light">
                    <i class="bi bi-person-circle me-2"></i>User Profile
                </h5>
            </div>
            <div class="card-body">
                <div class="profile-header text-center mb-4">
                    <div class="profile-avatar mb-3">
                        <i class="bi bi-person-circle" style="font-size: 4rem; color: #666;"></i>
                    </div>
                    <h4 class="text-light">{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>

                <div class="profile-details">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-secondary">
                                <div class="card-body">
                                    <h6 class="text-muted mb-3">Roles</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($user->roles as $role)
                                            <span class="badge bg-dark border border-secondary text-light">{{ $role->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-secondary">
                                <div class="card-body">
                                    <h6 class="text-muted mb-3">Permissions</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($permissions as $permission)
                                            <span class="badge bg-dark border border-secondary text-light">{{ $permission->display_name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    @if(auth()->user()->hasPermissionTo('admin_users') || auth()->id() == $user->id)
                        <a class="btn btn-outline-light" href="{{ route('edit_password', $user->id) }}">
                            <i class="bi bi-key me-2"></i>Change Password
                        </a>
                    @endif

                    @if(auth()->user()->hasPermissionTo('edit_users') || auth()->id() == $user->id)
                        <a href="{{ route('users_edit', $user->id) }}" class="btn btn-outline-light">
                            <i class="bi bi-pencil me-2"></i>Edit Profile
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
