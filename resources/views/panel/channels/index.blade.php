@extends('layouts.app')

@section('content')
<div class="container container--lg margin-top--lg">
    <div class="parent grid grid--gap-xs">
        <div class="col--lg-12">
            @include('extensions.alert')
            <div class="alert alert--is-visible js-alert margin-bottom--sm " role="alert">
                <div class="flex flex--center-y flex--space-between">
                    <div class="alert__content icon-text">
                        <p>{{ __('add_channel_note_1') }} <a href="https://t.me/{{ env('TELEGRAM_BOT_USERNAME') }}" target="_blank">{{ env('TELEGRAM_BOT_USERNAME') }}</a> {{ __('add_channel_note_2') }}</p>
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
            <div class="grid grid--gap-xs">
                <div class="col--lg-7">
                    <div class="table js-table">
                        <div class="table__inner js-table__inner">
                            <table cla aria-label="{{ __('Channels') }}">
                                <thead class="table__header">
                                    <tr>
                                        <th scope="col">{{ __('ID') }}</th>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Username') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="table__body js-table__body">
                                    @foreach($channels as $channel)
                                    <tr>
                                        <td>{{ $channel->id }}</td>
                                        <td>{{ $channel->name }}</td>
                                        <td>{{ $channel->username }}</td>
                                        <td>
                                            <div class="menu-wrapper js-menu-wrapper">
                                                <button class="btn btn--primary js-menu-trigger">{{ __('Action') }}</button>
                                                <menu class="menu js-menu">
                                                    <li class="menu__item js-menu__item" role="menuitem" aria-controls="modal-{{ $channel->id }}">
                                                        <div class="icon-text">
                                                            <svg class="icon menu__icon" aria-hidden="true" viewBox="0 0 12 12">
                                                                <path d="M10.121.293a1,1,0,0,0-1.414,0L1,8,0,12l4-1,7.707-7.707a1,1,0,0,0,0-1.414Z"></path>
                                                            </svg>
                                                            <span>{{ __('Edit Allowed Users') }}</span>
                                                        </div>
                                                    </li>
                                                    <li class="menu__item icon-text js-menu__item" role="menuitem" onclick="event.preventDefault();document.getElementById('form-{{ $channel->id }}').submit();">
                                                        <div class="icon-text">
                                                            <svg class="icon menu__icon" aria-hidden="true" viewBox="0 0 12 12">
                                                                <path d="M8.354,3.646a.5.5,0,0,0-.708,0L6,5.293,4.354,3.646a.5.5,0,0,0-.708.708L5.293,6,3.646,7.646a.5.5,0,0,0,.708.708L6,6.707,7.646,8.354a.5.5,0,1,0,.708-.708L6.707,6,8.354,4.354A.5.5,0,0,0,8.354,3.646Z"></path>
                                                                <path d="M6,0a6,6,0,1,0,6,6A6.006,6.006,0,0,0,6,0ZM6,10a4,4,0,1,1,4-4A4,4,0,0,1,6,10Z"></path>
                                                            </svg>
                                                            <span>{{ __('Delete') }}</span>
                                                        </div>
                                                    </li>
                                                    <form id="form-{{ $channel->id }}" action="{{ route('panel-channels-delete') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $channel->id }}">
                                                    </form>
                                                </menu>
                                                <div class="modal js-modal" id="modal-{{ $channel->id }}" data-animation="on">
                                                    <div class="modal__content" role="alertdialog" tabindex="-1" aria-labelledby="modalTitle1" aria-describedby="modalDescription1">
                                                        <header class="modal__header">
                                                            <h4 class="truncate" id="modalTitle1">{{ __('Allowed Users') }}</h4>
                                                        </header>
                                                        <form action="{{ route('panel-channels-edit') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $channel->id }}">
                                                            <div class="modal__body text--right">
                                                                <div>
                                                                    <label class="form-label" for="textarea">{{ __('Allowed Users Username') }}</label>
                                                                    <textarea class="form-control ltr" name="allowed_users" placeholder="username1,username2">@foreach($channel->channel_users as $user){{ $user->username . ',' }}@endforeach</textarea>
                                                                </div>
                                                            </div>
                                                            <footer class="modal__footer">
                                                                <div class="flex flex--end flex--gap-xs">
                                                                    <button class="btn btn--subtle js-modal__close">{{ __('Cancel') }}</button>
                                                                    <button class="btn btn--primary">{{ __('Save') }}</button>
                                                                </div>
                                                            </footer>
                                                        </form>
                                                    </div>
                                                    <button class="reset modal__close-btn js-modal__close">
                                                        <svg class="icon" viewBox="0 0 16 16">
                                                            <title>{{ __('Close') }}</title>
                                                            <g stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10">
                                                                <line x1="13.5" y1="2.5" x2="2.5" y2="13.5"></line>
                                                                <line x1="2.5" y1="2.5" x2="13.5" y2="13.5"></line>
                                                            </g>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if(count($channels))
                            {!! $channels->links('extensions.pagination') !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col--lg-5">
                    <form method="POST" action="{{ route('panel-channels-add') }}">
                        @csrf
                        <fieldset class="margin-bottom--md">
                            <legend class="form-legend">{{ __('Add Channel') }}</legend>
                            <div class="margin-bottom--sm">
                                <label class="form-label" for="txt-name">{{ __('Name') }}</label>
                                <input type="text" id="txt-name" class="form-control" name="name" placeholder="{{ __('Channel Name') }}" value="{{ old('name') }}">
                            </div>
                            <div class="margin-bottom--sm">
                                <label class="form-label" for="txt-username">{{ __('Username') }}</label>
                                <input type="text" id="txt-username" class="form-control ltr" name="username" placeholder="username" value="{{ old('username') }}">
                            </div>
                            <div class="margin-bottom--sm">
                                <label class="form-label" for="txt-allowed-users">{{ __('Allowed Users Username') }}</label>
                                <input type="text" id="txt-allowed-users" class="form-control ltr" name="allowed_users" placeholder="username1,username2" value="{{ old('allowed_users') }}">
                            </div>
                        </fieldset>
                        <div>
                            <button class="btn btn--primary">{{ __('Add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection