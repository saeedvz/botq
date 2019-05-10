@if(isset($text) && isset($type))
<div class="alert alert--is-visible js-alert margin-bottom--sm {{ $type }}" role="alert">
    <div class="flex flex--center-y flex--space-between">
        <div class="alert__content icon-text">
            <p>{{ $text }}</p>
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