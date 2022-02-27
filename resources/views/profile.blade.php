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
                    <div class="card-header">{{ __('Dashboard : Profile Update') }}</div>

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

                        <form method="POST" id="profileForm" name="profileForm"
                            action="{{ url('profile-update-submit') }}" enctype="multipart/form-data">
                            @csrf
                            @php
                                $user_data = \App\Models\User::find(Auth::user()->id);
                                $old_user = old();
                            @endphp
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
                                <label for="mobile"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Mobile') }}</label>
                                <div class="col-md-6">
                                    <input id="mobile" type="text"
                                        class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                                        value="{{ isset($user_data->mobile) && !isset($old_user['mobile']) ? $user_data->mobile : old('mobile') }}"
                                        maxlength="10" pattern="\d{10}" required autocomplete="mobile" autofocus>
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="address"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                                <div class="col-md-6">
                                    <textarea name='address' id='address'
                                        class="form-control">{{ isset($user_data->address) && !isset($old_user['address']) ? $user_data->address : old('address') }}</textarea>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="mobile"
                                    class="col-md-4 col-form-label text-md-end">{{ __('BirthDate') }}</label>
                                <div class="col-md-6">
                                    <input id="date_of_birth" type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        name="date_of_birth"
                                        value="{{ isset($user_data->date_of_birth) && !isset($old_user['date_of_birth'])? $user_data->date_of_birth: old('date_of_birth') }}"
                                        autocomplete="date_of_birth" required autofocus max="<?php echo date('Y-m-d'); ?>">
                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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

                            <div class="row mb-3">
                                <label for="formFile"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>
                                <div class="col-md-6">
                                    <input class='form-control @error('formFile') is-invalid @enderror' type='file'
                                        name='formFile' id='formFile' accept='image/*'> </br>
                                    @php
                                        // php artisan storage:link
                                        // from storage folder image path
                                        $image = asset("/storage/asset/$user_data->profile_image");
                                        // from public folder image path
                                        /* $image = asset("/images/public-image.png"); */
                                    @endphp
                                    <img id="formFile_src" src='{{ $image }}' alt='{{ __('sample-image.jpg') }}'
                                        height="125" width="125">
                                    &nbsp;<button type="button" class="btn btn-outline-danger btn-sm img_close"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    @error('formFile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="role_id"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>
                                <div class="col-md-6">
                                    @php
                                        $roles_list = \App\Models\Roles::where('status', 1)->get();
                                        
                                    @endphp
                                    <select class='form-control @error('role_id') is-invalid @enderror' name='role_id'
                                        id='role_id'>
                                        @if (isset($roles_list) && $roles_list->isNotEmpty())
                                            <option value='' disabled aria-readonly="true" selected> Select.. </option>
                                            @foreach ($roles_list as $role_key => $role_val)
                                                @php
                                                    $selected = '';
                                                    if (isset($user_data->role_id) && !isset($old_user['role_id']) && $user_data->role_id == $role_val['id']) {
                                                        $selected = 'selected';
                                                    } elseif (isset($old_user['role_id']) && $old_user['role_id'] == $role_val['id']) {
                                                        $selected = 'selected';
                                                    }
                                                @endphp
                                                <option value='{{ $role_val['id'] }}' {{ $selected }}>
                                                    {{ $role_val['name'] }} </option>
                                            @endforeach
                                        @else
                                            <option value='' disabled readonly> No records found..! </option>
                                        @endif
                                    </select>
                                    @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="hobbies"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Hobbies') }}</label>
                                <div class="col-md-6">
                                    @php
                                        $hobbies_dance = '';
                                        if (str_contains($user_data->hobbies, 'dance') && !isset($old_user['hobbies'])) {
                                            $hobbies_dance = 'checked';
                                        } elseif (isset($old_user['hobbies']) && in_array('dance', $old_user['hobbies'])) {
                                            $hobbies_dance = 'checked';
                                        }
                                        
                                        $hobbies_read = '';
                                        if (str_contains($user_data->hobbies, 'read') && !isset($old_user['hobbies'])) {
                                            $hobbies_read = 'checked';
                                        } elseif (isset($old_user['hobbies']) && in_array('read', $old_user['hobbies'])) {
                                            $hobbies_read = 'checked';
                                        }
                                        
                                        $hobbies_draw = '';
                                        if (str_contains($user_data->hobbies, 'draw') && !isset($old_user['hobbies'])) {
                                            $hobbies_draw = 'checked';
                                        } elseif (isset($old_user['hobbies']) && in_array('draw', $old_user['hobbies'])) {
                                            $hobbies_draw = 'checked';
                                        }
                                        
                                    @endphp
                                    <input type="checkbox" class='@error('hobbies') is-invalid @enderror' name="hobbies[]"
                                        value="dance" {{ $hobbies_dance }}>Dance </br>
                                    <input type="checkbox" class='@error('hobbies') is-invalid @enderror' name="hobbies[]"
                                        value="read" {{ $hobbies_read }}>Reading </br>
                                    <input type="checkbox" class='@error('hobbies') is-invalid @enderror' name="hobbies[]"
                                        value="draw" {{ $hobbies_draw }}>Drawing
                                    @error('hobbies')
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
