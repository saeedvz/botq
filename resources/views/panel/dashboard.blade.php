@extends('layouts.app')

@section('content')
<div class="container container--lg margin-top--lg">
    <div class="parent grid grid--gap-xs">
        <div class="col--lg-12">
            @include('extensions.alert-note', ['type' => 'alert--info', 'text' => __('Welcome')])
        </div>
    </div>
</div>
@stop