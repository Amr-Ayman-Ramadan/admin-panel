@extends("layout.master")
@section("title", "Create User")

@section("content")
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-lg p-4">
                    <div class="card-header text-center">
                        <h3>Create User</h3>
                        <p class="mt-1 mb-0">Fill out the form below to create a new user.</p>
                    </div>
                    <div class="card-body">
                        <form id="userForm" action="{{ route('users.store') }}" method="POST" class="row g-3">
                         @include("Pages.Users.form")
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
