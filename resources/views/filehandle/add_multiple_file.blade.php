@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Multiple File Upload') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session()->has('success'))
                    <div class="alert alert-success">
                    {{ session()->get('success') }}
                    </div>
                    @elseif(session()->has('errors'))
                    <div class="alert alert-danger">
                    <ul>
                    @foreach (session()->get('errors') as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                    </div>
                    @endif

                    <!-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif -->

        

                    <form name="multiple_file_upload" id="multiple_file_upload" action="{{ url('multifile-upload-submit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='mb-3'>
                        <label for='formFile' class='form-label'>Multiple File Upload</label>
                        <input class='form-control' type='file' name='formFile[]' id='formFile' accept='image/*' multiple>
                        </div>
                        
                        <div class="mb-3">
                          <button type='submit' class='btn btn-primary btn-sm'>Upload</button>
                        </div>
                    </form>
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
