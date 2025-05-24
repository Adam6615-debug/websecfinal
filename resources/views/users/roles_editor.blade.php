@extends('layouts.master')
@section('title', 'Role Editor')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Role Editor</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('roles_save') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="role_id">
                <div class="mb-3">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="role_name" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Permissions</label>
                    <div class="row">
                        @foreach($permissions as $permission)
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                <label class="form-check-label" for="perm_{{ $permission->id }}">{{ $permission->display_name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Role</button>
            </form>
        </div>
        <div class="col-md-6">
            <h4>Existing Roles</h4>
            <ul class="list-group">
                @foreach($roles as $role)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <strong>{{ $role->name }}</strong>
                        <br>
                        <small>
                            @foreach($role->permissions as $perm)
                                <span class="badge bg-success">{{ $perm->display_name }}</span>
                            @endforeach
                        </small>
                    </span>
                    <button class="btn btn-sm btn-secondary" onclick="editRole({{ $role->id }}, '{{ $role->name }}', @json($role->permissions->pluck('name'))) ">Edit</button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<script>
function editRole(id, name, permissions) {
    document.getElementById('role_id').value = id;
    document.getElementById('role_name').value = name;
    // Uncheck all permissions first
    document.querySelectorAll('input[name="permissions[]"]').forEach(cb => {
        cb.checked = false;
    });
    // Check only those in the role
    if (Array.isArray(permissions)) {
        permissions.forEach(function(p) {
            let cb = document.querySelector('input[name="permissions[]"][value="' + p + '"]');
            if (cb) cb.checked = true;
        });
    }
}
</script>
@endsection
