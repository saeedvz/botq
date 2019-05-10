@extends('layouts.app')

@section('content')
<div class="container container--lg margin-top--lg">
    <div class="parent grid grid--gap-xs">
        <div class="col--sm"></div>
        <div class="col--sm">
            <form class="password-form" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="text-component text--center margin-bottom--md">
                    <h1>{{ __('Reset Password') }}</h1>
                </div>
                @include('extensions.alert')
                <div class="margin-bottom--sm">
                    <label class="form-label" for="txt-email">{{ __('E-Mail Address') }}</label>
                    <input class="form-control ltr" type="email" name="email" id="txt-email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                <div class="margin-bottom--sm">
                    <button class="btn btn--primary btn--md btn--full-width">{{ __('Send Password Reset Link') }}</button>
                </div>
                <div class="text--center">
                    <p class="text--sm"><a href="{{ route('login') }}">{{ __('Back to login') }}</a></p>
                </div>
            </form>
        </div>
        <div class="col--sm"></div>
    </div>
</div>
@endsection