@extends('layouts.app')

@section('content')
<div class="container container--lg margin-top--lg">
    <div class="parent grid grid--gap-xs">
        <div class="col--sm"></div>
        <div class="col--sm">
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="text-component text--center margin-bottom--md">
                    <h1>{{ __('Login') }}</h1>
                    <p>{{ __('Login to account') }}</p>
                </div>
                @include('extensions.alert')
                <div class="margin-bottom--sm">
                    <label class="form-label" for="txt-email">{{ __('E-Mail Address') }}</label>
                    <input class="form-control ltr" type="email" name="email" id="txt-email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                <div class="margin-bottom--sm">
                    <div class="flex flex--space-between">
                        <label class="form-label" for="txt-password">{{ __('Password') }}</label>
                        <span class="text--sm">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                        </span>
                    </div>
                    <input class="form-control ltr" type="password" name="password" id="txt-password">
                </div>
                <div class="margin-bottom--sm">
                    <button class="btn btn--primary btn--md btn--full-width">{{ __('Login') }}</button>
                </div>
                <div class="text--center">
                    <p class="text--sm">{{ __("Don't have an account?") }} <a href="{{ route('register') }}">{{ __('Get started') }}</a></p>
                </div>
            </form>
        </div>
        <div class="col--sm"></div>
    </div>
</div>
@endsection