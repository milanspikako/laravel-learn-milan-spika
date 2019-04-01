@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('Change password') }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Change password') }} for user {{ $user->name }}</h1>

@include('admin.layout.partials.messages')

<div class='row'>
    <div class="offset-lg-2 col-lg-8">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name='password' class="form-control">
                        @if($errors->has('password'))
                        <div class='text text-danger'>
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input type="password" name='password_confirmation' class="form-control">
                    </div>
                    
                    <div class="form-group text-right">
                        <button type='submit' class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('custom-js')

@endsection

