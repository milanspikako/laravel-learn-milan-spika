@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('Edit') . ' ' . $user->name }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Edit') . ' ' . $user->name }}</h1>
<div class='row'>
    <div class="offset-lg-2 col-lg-8">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('Admin user details') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name='name' value='{{ old("name", $user->name) }}' class="form-control">
                        @if($errors->has('name'))
                        <div class='text text-danger'>
                            {{ $errors->first('name') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input disabled type="text" name='email' value='{{ old("email", $user->email) }}' class="form-control" placeholder="name@example.com">
                        @if($errors->has('email'))
                        <div class='text text-danger'>
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name='phone' value='{{ old("phone", $user->phone) }}' class="form-control">
                        @if($errors->has('phone'))
                        <div class='text text-danger'>
                            {{ $errors->first('phone') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name='address' value='{{ old("address", $user->address) }}' class="form-control">
                        @if($errors->has('address'))
                        <div class='text text-danger'>
                            {{ $errors->first('address') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group {{ (auth()->user()->role == \App\User::MODERATOR) ? 'd-none' : '' }}">
                        <label>Role</label>
                        <select class="form-control" name="role">
                            <option value=''>-- Choose role --</option>
                            <option value='{{ \App\User::ADMINISTRATOR }}' {{ (old('role', $user->role) == \App\User::ADMINISTRATOR) ? 'selected':'' }}>{{ ucfirst(\App\User::ADMINISTRATOR) }}</option>
                            <option value='{{ \App\User::MODERATOR }}' {{ (old('role', $user->role) == \App\User::MODERATOR) ? 'selected':'' }}>{{ ucfirst(\App\User::MODERATOR) }}</option>
                        </select>
                        @if($errors->has('role'))
                        <div class='text text-danger'>
                            {{ $errors->first('role') }}
                        </div>
                        @endif
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

