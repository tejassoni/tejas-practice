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
                <div class="card-header">{{ __('Register') }}</div>
                @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
                @elseif(session()->has('errors'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ session()->get('errors') }}</li>
                    </ul>
                </div>
                @endif
                <div class="card-body">
                    <form method="POST" id="registerForm" name="registerForm" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))' required autocomplete="name" autofocus>

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
                            $gender_old = old('gender');
                            @endphp
                            <div class="col-md-6">
                                <input type='radio' name='gender' value='m' {{ (isset($gender_old) && ($gender_old == 'm') || !isset($gender_old))?'checked':'' }}> Male
                                <input type='radio' name='gender' value='f' {{(isset($gender_old) && $gender_old == 'f')?'checked':'' }}> Female<br>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="mobile" class="col-md-4 col-form-label text-md-end">{{ __('Mobile') }}</label>
                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" maxlength="10" pattern="\d{10}" required autocomplete="mobile" autofocus>
                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <textarea name='address' id='address' class="form-control">{{ old('address') }}</textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">{{ __('BirthDate') }}</label>
                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" autocomplete="date_of_birth" required autofocus max="<?php echo date("Y-m-d"); ?>">
                                @error('date_of_birth')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="formFile" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>
                            <div class="col-md-6">
                                <input class='form-control @error(' formFile') is-invalid @enderror' type='file' name='formFile' id='formFile' accept='image/*'> </br>
                                <img id="formFile_src" src="#" alt="sample-image.jpg" height="125" width="125" />&nbsp;<button type="button" class="btn btn-outline-danger btn-sm img_close" aria-label="Close">
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
                            <label for="role_id" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>
                            <div class="col-md-6">
                                @php
                                $roles_list = \App\Models\Roles::where('status',1)->get();
                                $roles_old = old('role_id');
                                @endphp
                                <select class='form-control @error(' role_id') is-invalid @enderror' name='role_id' id='role_id'>
                                    @if(isset($roles_list) && $roles_list->isNotEmpty())
                                    <option value='' disabled aria-readonly="true" selected> Select.. </option>
                                    @foreach($roles_list as $role_key => $role_val)
                                    <option value='{{ $role_val['id'] }}' {{(isset($roles_old) && $roles_old == $role_val['id'])?'selected':'' }}> {{ $role_val['name'] }} </option>
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
                            <label for="hobbies" class="col-md-4 col-form-label text-md-end">{{ __('Hobbies') }}</label>
                            <div class="col-md-6">
                                @php
                                $hobbies_old = old('hobbies');
                                @endphp
                                <input type="checkbox" class='hobbies @error(' hobbies') is-invalid @enderror' name="hobbies[]" value="dance" {{ (isset($hobbies_old) && in_array('dance',$hobbies_old))?'checked':'' }}>Dance </br>
                                <input type="checkbox" class='hobbies @error(' hobbies') is-invalid @enderror' name="hobbies[]" value="read" {{ (isset($hobbies_old) && in_array('read',$hobbies_old))?'checked':'' }}>Reading </br>
                                <input type="checkbox" class='hobbies @error(' hobbies') is-invalid @enderror' name="hobbies[]" value="draw" {{ (isset($hobbies_old) && in_array('draw',$hobbies_old))?'checked':'' }}>Drawing
                                @error('hobbies')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn_register_submit">
                                    {{ __('Register') }}
                                </button>
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
              $("#formFile_src").attr('src','#');
              $(this).hide();
        });
        // File Image Preview Ends

        // jquery validation client side
        $("#registerForm").validate({
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
                formFile: {
                    required: true,
                    extension: "jpg|jpeg|png|ico|bmp"
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
                formFile: {
                    required: "Please upload file.",
                    extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp)."
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
    });
</script>
@endpush