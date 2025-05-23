@extends('layouts.master')

@section('title', 'Users')

@section('content')
<div class="row mt-3 mb-2">
  <div class="col-md-8">
    <h2 class="fw-bold">Users</h2>
  </div>
</div>

{{-- Role-based message --}}
@if(auth()->user()->hasRole('Admin'))
<div class="alert alert-success">You are viewing all users (Admin).</div>
@elseif(auth()->user()->hasRole('Employee'))
<div class="alert alert-info">You are viewing customers only (Employee).</div>
@endif

<form class="mb-3">
  <div class="row g-2">
    <div class="col-md-3">
      <input name="keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
    </div>
    <div class="col-md-auto">
      <button type="submit" class="btn btn-primary w-100">Search</button>
    </div>
    <div class="col-md-auto">
      <a href="{{ route('users') }}" class="btn btn-danger w-100">Reset</a>
    </div>
    <div class="col-md-auto">
      <a href="{{ route('addemployee') }}" class="btn btn-success w-100">Add Employee</a>
    </div>
  </div>
</form>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Credit</th>
            <th>Roles</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>${{ $user->credit }}</td>
            <td>
              @foreach($user->roles as $role)
              <span class="badge bg-primary">{{ $role->name }}</span>
              @endforeach
            </td>
            <td>{{ $user->blocked_status }}</td>
            <td>
              <div class="d-flex flex-wrap gap-1">
                @can('edit_users')
                <a class="btn btn-sm btn-primary" href="{{ route('users_edit', [$user->id]) }}">Edit</a>
                @endcan

                @can('admin_users')
                <a class="btn btn-sm btn-secondary" href="{{ route('edit_password', [$user->id]) }}">Password</a>
                @endcan

                @can('delete_users')
                <a class="btn btn-sm btn-danger" href="{{ route('users_delete', [$user->id]) }}">Delete</a>
                @endcan

                @canany(['admin_users', 'edit_users'])
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addCreditModal{{ $user->id }}">
                  + Credit
                </button>
                @endcanany
              </div>

              {{-- Modal --}}
              <div class="modal fade" id="addCreditModal{{ $user->id }}" tabindex="-1" aria-labelledby="addCreditModalLabel{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog">
                  <form method="POST" action="{{ route('users_add_credit', $user->id) }}">
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Add Credit for {{ $user->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <input type="number" name="credit" min="0" class="form-control" placeholder="Enter credit amount" required oninput="checkNegative(this)" id="creditInput{{ $user->id }}" />
                        <small id="creditError{{ $user->id }}" class="form-text text-danger" style="display: none;">Credit cannot be negative.</small>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="addCreditButton{{ $user->id }}">Add Credit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              {{-- End Modal --}}
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function checkNegative(input) {
  const userId = input.id.split('creditInput')[1];
  const errorMessage = document.getElementById('creditError' + userId);
  const addButton = document.getElementById('addCreditButton' + userId);

  if (input.value < 0) {
    errorMessage.style.display = 'block';
    addButton.disabled = true;
  } else {
    errorMessage.style.display = 'none';
    addButton.disabled = false;
  }
}
</script>

@endsection
