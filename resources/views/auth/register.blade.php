@extends('layouts.app')

@section('content')
<div class="container container--lg margin-top--lg">
    <div class="parent grid grid--gap-xs">
        <div class="col--sm"></div>
        <div class="col--sm">
            <form class="register-form" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="text-component text--center margin-bottom--md">
                    <h1>{{ __('Register') }}</h1>
                    <p>{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Login to account') }}</a></p>
                </div>
                @include('extensions.alert')
                <div class="margin-bottom--sm">
                    <label class="form-label" for="txt-name">{{ __('Name') }}</label>
                    <input class="form-control" type="text" name="name" id="txt-name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
                <div class="margin-bottom--sm">
                    <label class="form-label" for="txt-email">{{ __('E-Mail Address') }}</label>
                    <input class="form-control ltr" type="email" name="email" id="txt-email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                <div class="margin-bottom--sm">
                    <label class="form-label" for="txt-password">{{ __('Password') }}</label>
                    <input class="form-control ltr" type="password" name="password" id="txt-password">
                </div>
                <div class="margin-bottom--sm">
                    <label class="form-label" for="txt-password-confirm">{{ __('Confirm Password') }}</label>
                    <input class="form-control ltr" type="password" name="password_confirmation" id="txt-password-confirm">
                </div>
                <div class="margin-bottom--sm">
                    <button class="btn btn--primary btn--md btn--full-width">{{ __('Register') }}</button>
                </div>
            </form>
        </div>
        <div class="col--sm"></div>
    </div>
</div>
@endsection