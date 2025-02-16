@csrf

<!-- Name Field -->
<div class="col-12">
    <label class="form-label" for="name">Name</label>
    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="Enter name" value="{{ old('name', isset($user) ? $user->name : '') }}" style="width: 100%;">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Email Field -->
<div class="col-12">
    <label class="form-label" for="email">Email Address</label>
    <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" placeholder="Enter email" value="{{ old('email', isset($user) ? $user->email : '') }}" style="width: 100%;">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Type Field -->
<div class="col-12">
    <label class="form-label" for="type">User Type</label>
    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" style="width: 100%;">
        <option selected disabled value="">Choose...</option>
        <option value="student" @selected(old('type', $user->type ?? '') == 'student')>Student</option>
        <option value="teacher" @selected(old('type', $user->type ?? '') == 'teacher')>Teacher</option>
    </select>
    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Birthdate Field -->
<div class="col-12">
    <label class="form-label" for="birthdate">Birthdate</label>
    <input class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" type="date" name="birthdate" value="{{ old('birthdate', isset($user) ? $user->birthdate : '') }}" style="width: 100%;">
    @error('birthdate') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Status Field -->
<div class="col-12">
    <label class="form-label" for="status">Status</label>
    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" style="width: 100%;">
        <option selected disabled value="">Choose...</option>
        <option value="active" @selected(old('status', $user->status ?? '') == 'active')>Active</option>
        <option value="inactive" @selected(old('status', $user->status ?? '') == 'inactive')>Inactive</option>
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Courses Selection -->
<div class="col-12">
    <label class="form-label" for="courses">Courses</label>
    <select class="form-select select2" id="courses" name="courses[]" multiple style="width: 100%;">
        @foreach($courses as $course)
            <option value="{{ $course->id }}"
                    @if(isset($user) && $user->courses->contains($course->id)) selected @endif>
                {{ $course->name }}
            </option>
        @endforeach
    </select>
</div>


<div class="col-12 text-center">
    <button class="btn btn-primary w-100" type="submit">Submit</button>
</div>

<script>
    $(document).ready(function () {
        $('#birthdate').attr('max', new Date().toISOString().split('T')[0]);

        $('.select2').select2({
            placeholder: "Select courses",
            allowClear: true
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#userForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 50,
                    pattern: /^[A-Za-z\s]+$/
                },
                email: {
                    required: true,
                    email: true
                },
                type: {
                    required: true
                },
                birthdate: {
                    required: true,
                    date: true
                },
                status: {
                    required: true
                },
                'courses[]': {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter a name",
                    minlength: "Name must be at least 3 characters long",
                    maxlength: "Name cannot exceed 50 characters",
                    pattern: "Name can only contain letters and spaces"
                },
                email: {
                    required: "Please enter an email address",
                    email: "Please enter a valid email address"
                },
                type: {
                    required: "Please select a user type"
                },
                birthdate: {
                    required: "Please select a birthdate",
                    date: "Please enter a valid date"
                },
                status: {
                    required: "Please select a status"
                },
                'courses[]': {
                    required: "Please select at least one course"
                }
            },
            submitHandler: function (form, event) {
                event.preventDefault();
                var formData = $(form).serialize();

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: formData,
                    success: function (response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message || 'User saved successfully.',
                            icon: 'success',
                        }).then(() => {
                            window.location.href = "{{ route('users.index') }}";
                        });
                    },
                    error: function (xhr) {
                        let errorMessage = 'An error occurred.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            errorMessage = xhr.responseText;
                        }

                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                        });
                    }
                });
            }
        });
    });
</script>
