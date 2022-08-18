@extends('layouts.app')
@push('header-styles')
    <style>
        .error {
            color: red;
            font-weight: 400;
            display: block;
            padding: 6px 0;
            font-size: 14px;
        }

        .form-control.error {
            border-color: red;
            padding: .375rem .75rem;
        }

    </style>
@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard : Change Password') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('errors'))
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" id="changePasswordForm" name="changePasswordForm"
                            action="{{ url('profile-update-submit') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name"
                                        value="{{ isset($user_data->name) && !isset($old_user['name']) ? $user_data->name : old('name') }}"
                                        onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))'
                                        required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>
                                @php
                                    $male_checked = '';
                                    if ((isset($user_data) && $user_data->gender == 'm') || !isset($old_user)) {
                                        $male_checked = 'checked';
                                    } elseif (isset($old_user['gender']) && $old_user['gender'] == 'm') {
                                        $male_checked = 'checked';
                                    }
                                    
                                    $female_checked = '';
                                    if ((isset($user_data) && $user_data->gender == 'f') || !isset($old_user)) {
                                        $female_checked = 'checked';
                                    } elseif (isset($old_user['gender']) && $old_user['gender'] == 'f') {
                                        $female_checked = 'checked';
                                    }
                                @endphp
                                <div class="col-md-6">
                                    <input type='radio' name='gender' value='m' {{ $male_checked }}> Male
                                    <input type='radio' name='gender' value='f' {{ $female_checked }}> Female<br>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email"
                                        value="{{ isset($user_data->email) && !isset($old_user['email']) ? $user_data->email : old('email') }}"
                                        required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                     

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                    <a href="{{ url('home') }}" class="btn btn-warning">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer-scripts')
    <script type='text/javascript'>
        $(document).ready(function() {
            /* $("input[name='hobbies[]']").change(function() {
                 var maxAllowed = 1;
                 var cnt = $("input[name='hobbies[]']:checked").length;
                 if (cnt > maxAllowed) {
                     $(this).prop("checked", "");
                     alert('Select maximum ' + maxAllowed + ' Levels!');
                 }
             }); */

            // jQuery Validation : custom alpha method
            jQuery.validator.addMethod("alpha", function(value, element) {
                return this.optional(element) || /^[A-Za-z\s]+$/.test(value) // just ascii letters
            }, "Alpha only");

            // jquery validation client side
            $("#profileForm").validate({
                rules: {
                    name: {
                        required: true,
                        alpha: true
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
                    },
                    date_of_birth: {
                        required: true,
                        date: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    role_id: {
                        required: true,
                    },
                    "hobbies[]": {
                        required: true,
                        minlength: 2
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Name is required",
                        alpha: "Name must be string only"
                    },
                    mobile: {
                        required: "Please provide a Mobile number",
                        minlength: "Mobile number must be min 10 characters long",
                        maxlength: "Mobile number must not be more than 10 characters long",
                        number: "Only numbers are allowed"
                    },
                    date_of_birth: {
                        required: "Birthdate is required",
                    },
                    role_id: {
                        required: "Role is required"
                    },
                    "hobbies[]": {
                        required: "Hobbies are required",
                        minlength: "Atleast 2 Hobbies are required",
                    },
                    password: {
                        required: "Password is required",
                        minlength: "Password must be min 10 characters long",
                    },
                    password_confirmation: {
                        required: "Confirm Password is required",
                        equalTo: "Confirm Password must be same as Password field",
                    }
                }
            });

            // File Image Preview Starts
            // onchange image display type=file id=formFile
            formFile.onchange = evt => {
                const [file] = formFile.files
                if (file) {
                    // img tag id=formFile_src
                    formFile_src.src = URL.createObjectURL(file)
                    $('.img_close').show();
                }
            }

            // after image preview hide
            $('.img_close').hide();
            $(document).on('click', '.img_close', function() {
                $("#formFile").val('');
                $("#formFile_src").attr('src', '#');
                $(this).hide();
            });
            // File Image Preview Ends
        });
    </script>
@endpush
