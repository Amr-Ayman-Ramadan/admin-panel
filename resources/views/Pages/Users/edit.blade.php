@extends("layout.master")
@section("title", "Edit User")

@section("content")
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-lg p-4">
                    <div class="card-header text-center">
                        <h3>Edit User</h3>
                        <p class="mt-1 mb-0">Fill out the form below to update this user.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update',$user) }}" method="POST" class="row g-3">
                            @method("PUT")
                            <input type="hidden" name="userId" value="{{$user->id}}">
                            @include("Pages.Users.form")
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
