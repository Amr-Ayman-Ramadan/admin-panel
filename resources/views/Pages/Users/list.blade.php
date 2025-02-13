@extends('layout.master')

@section('title', 'Users')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Users</h1>

        <!-- Action Buttons -->
        <div class="d-flex align-items-center mb-3">
            <!-- Create User Button -->
            <a href="{{ route('users.create') }}" class="btn btn-primary me-2 d-inline-flex align-items-center" data-bs-toggle="tooltip" title="Create a new user">
                <i class="fa-solid fa-user-plus me-2"></i> Create User
            </a>
            <!-- Export Users Button -->
            <a href="{{ route('users.export') }}" class="btn btn-success d-inline-flex align-items-center" data-bs-toggle="tooltip" title="Export users to CSV">
                <i class="fa-solid fa-file-arrow-down me-2"></i> Export Users
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-light text-center">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Birthdate</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">{{ ucfirst($user->type) }}</td>
                        <td class="text-center">{{ $user->birthdate }}</td>
                        <td class="text-center">
                                <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                        </td>
                        <td class="text-center">
                            <!-- Action Buttons -->
                            <div class="btn-group" role="group">
                                <!-- Edit Button -->
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit User">
                                    <i class="fa-solid fa-edit"></i>
                                </a>

                                <!-- Delete Button with Modal -->
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}" title="Delete User">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                <!-- Status Toggle Button -->
                                <a href="{{ route('users.changeStatus', $user) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Change Status">
                                    <i class="fa-solid {{ $user->status === 'active' ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete <strong>{{ $user->name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap Tooltip Initialization -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
