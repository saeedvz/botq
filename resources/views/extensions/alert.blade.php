@if (isset($errors) && count($errors) > 0 || session('message'))
<div class="alert alert--is-visible js-alert margin-bottom--sm @if (isset($errors) && count($errors) > 0) alert--error @endif @if(session('alert')) alert--{{ session('alert') }} @endif" role="alert">
    <div class="flex flex--center-y flex--space-between">
        <div class="alert__content icon-text">
            @if($errors->all())
            <ul>
                @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
                @endforeach
            </ul>
            @endif
            @if(session('message'))
            <p>
                {{ session('message') }}
            </p>
            @endif
        </div>
        <button class="reset alert__close-btn js-alert__close-btn">
            <svg class="icon" viewBox="0 0 24 24">
                <title>Close alert</title>
                <g stroke-linecap="square" stroke-linejoin="miter" stroke-width="3" stroke="currentColor" fill="none" stroke-miterlimit="10">
                    <line x1="19" y1="5" x2="5" y2="19"></line>
                    <line fill="none" x1="19" y1="19" x2="5" y2="5"></line>
                </g>
            </svg>
        </button>
    </div>
</div>
@endif
