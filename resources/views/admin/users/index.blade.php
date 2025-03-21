@extends('layouts.app')

@section('title', 'User Management')

@section('styles')
    <style>
        .user-card {
            transition: all 0.3s;
        }

        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            color: var(--primary-color);
        }

        .status-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">User Management</h1>
        </div>

        <!-- Filters and Search -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.users.index') }}"
                                class="btn {{ !request('type') ? 'btn-primary' : 'btn-outline-primary' }}">All Users</a>
                            <a href="{{ route('admin.users.index', ['type' => 'admin']) }}"
                                class="btn {{ request('type') == 'admin' ? 'btn-primary' : 'btn-outline-primary' }}">Admins</a>
                            <a href="{{ route('admin.users.index', ['type' => 'client']) }}"
                                class="btn {{ request('type') == 'client' ? 'btn-primary' : 'btn-outline-primary' }}">Clients</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('admin.users.index') }}" method="GET">
                            @if (request('type'))
                                <input type="hidden" name="type" value="{{ request('type') }}">
                            @endif
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search users..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th scope="col">User</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Role</th>
                                <th scope="col">Created</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? 'Not provided' }}</td>
                                    <td>
                                        <span class="badge {{ $user->is_admin ? 'bg-primary' : 'bg-success' }}">
                                            {{ $user->is_admin ? 'Admin' : 'Client' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('admin.users.show', $user) }}"
                                                class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                                data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-users display-1 text-muted mb-3"></i>
                                            <h5>No users found</h5>
                                            <p class="text-muted">
                                                {{ request('search') ? 'Try a different search term' : 'Users will appear here when added' }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                    <p class="fw-bold user-name"></p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteUserForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup delete user modal
            const deleteUserModal = document.getElementById('deleteUserModal');
            if (deleteUserModal) {
                deleteUserModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const userId = button.getAttribute('data-user-id');
                    const userName = button.getAttribute('data-user-name');

                    const userNameElement = this.querySelector('.user-name');
                    userNameElement.textContent = userName;

                    const form = this.querySelector('#deleteUserForm');
                    form.action = `{{ url('/admin/users') }}/${userId}`;
                });
            }
        });
    </script>
@endsection
