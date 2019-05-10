@extends('layouts.app')

@section('content')
<section class="hero hero--center" id="hero-home">
    <div class="container container--adaptive-sm">
        <div class="hero__content">
            <div class="text-component margin-bottom--sm">
                <small class="hero__label">{{ env('APP_NAME') }}</small>
                <h1>{{ __('site_title') }}</h1>
                <p>{{ __('site_slug') }}</p>
            </div>
            <a href="{{ route('register') }}" class="btn btn--primary">{{ __('Register') }}</a>
        </div>
    </div>
</section>
<div class="newsletter margin-top--sm margin-bottom--sm">
    <div class="container container--sm">
        <h2>{{ __('Join our Newsletter') }}</h2>
        <div class="margin-top--sm margin-bottom--md">
            <p class="newsletter__description">{{ __('Get our monthly recap with the latest news, articles and resources.') }}</p>
        </div>
        <form class="newsletter__form">
            <input aria-label="Email address" class="form-control" type="email" placeholder="{{ __('E-Mail Address') }}">
            <button class="btn btn--primary">{{ __('Subscribe') }}</button>
        </form>
    </div> <!-- container -->
</div>
@endsection