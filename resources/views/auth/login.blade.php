@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Login') }}</div>

            <div class="card-body">
                <form action="{{route('login')}}" method="POST">
                    @csrf
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email address</label>
                        <input type="email" id="email" name="email" class="form-control" />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" />
                    </div>

                    <!-- Submit button -->
                    @if (session()->has('error'))
                        <span class="text-danger mr-2"> {{ session('error') }}</span>
                    @endif
                    <div class="text-right">

                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
