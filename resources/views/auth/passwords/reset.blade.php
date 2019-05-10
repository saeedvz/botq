@extends('layouts.app')

@section('content')
<div class="container container--lg margin-top--lg">
    <div class="parent grid grid--gap-xs">
        <div class="col--sm"></div>
        <div class="col--sm">
            <form class="password-form" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="text-component text--center margin-bottom--md">
                    <h1>{{ __('Reset Password') }}</h1>
                </div>
                @include('extensions.alert')
                <div class="margin-bottom--sm">
                    <label class="form-label" for="txt-password">{{ __('Password') }}</label>
                    <input class="form-control ltr" type="password" name="password" id="txt-password">
                </div>
                <div class="margin-bottom--sm">
                    <label class="form-label" for="txt-password-confirm">{{ __('Confirm Password') }}</label>
                    <input class="form-control ltr" type="password" name="password_confirmation" id="txt-password-confirm">
                </div>
                <div class="margin-bottom--sm">
                    <button class="btn btn--primary btn--md btn--full-width">{{ __('Reset Password') }}</button>
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