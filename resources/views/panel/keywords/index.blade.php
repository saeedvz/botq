@extends('layouts.app')

@section('content')
<div class="container container--lg margin-top--lg">
    <div class="parent grid grid--gap-xs">
        <div class="col--lg-12">
            @include('extensions.alert')
            <div class="grid grid--gap-xs">
                <div class="col--lg-7">
                    <div class="table js-table">
                        <div class="table__inner js-table__inner">
                            <table cla aria-label="{{ __('Keywords') }}">
                                <thead class="table__header">
                                    <tr>
                                        <th scope="col">{{ __('ID') }}</th>
                                        <th scope="col">{{ __('Keyword') }}</th>
                                        <th scope="col">{{ __('Replace') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="table__body js-table__body">
                                    @foreach($keywords as $keyword)
                                    <tr>
                                        <td>{{ $keyword->id }}</td>
                                        <td>{{ $keyword->keyword }}</td>
                                        <td>{{ $keyword->replace }}</td>
                                        <td>
                                            <div class="menu-wrapper js-menu-wrapper">
                                                <button class="btn btn--primary js-menu-trigger">{{ __('Action') }}</button>
                                                <menu class="menu js-menu">
                                                    <li class="menu__item js-menu__item" role="menuitem" aria-controls="modal-{{ $keyword->id }}">
                                                        <div class="icon-text">
                                                            <svg class="icon menu__icon" aria-hidden="true" viewBox="0 0 12 12">
                                                                <path d="M10.121.293a1,1,0,0,0-1.414,0L1,8,0,12l4-1,7.707-7.707a1,1,0,0,0,0-1.414Z"></path>
                                                            </svg>
                                                            <span>{{ __('Edit') }}</span>
                                                        </div>
                                                    </li>
                                                    <li class="menu__item icon-text js-menu__item" role="menuitem" onclick="event.preventDefault();document.getElementById('form-{{ $keyword->id }}').submit();">
                                                        <div class="icon-text">
                                                            <svg class="icon menu__icon" aria-hidden="true" viewBox="0 0 12 12">
                                                                <path d="M8.354,3.646a.5.5,0,0,0-.708,0L6,5.293,4.354,3.646a.5.5,0,0,0-.708.708L5.293,6,3.646,7.646a.5.5,0,0,0,.708.708L6,6.707,7.646,8.354a.5.5,0,1,0,.708-.708L6.707,6,8.354,4.354A.5.5,0,0,0,8.354,3.646Z"></path>
                                                                <path d="M6,0a6,6,0,1,0,6,6A6.006,6.006,0,0,0,6,0ZM6,10a4,4,0,1,1,4-4A4,4,0,0,1,6,10Z"></path>
                                                            </svg>
                                                            <span>{{ __('Delete') }}</span>
                                                        </div>
                                                    </li>
                                                    <form id="form-{{ $keyword->id }}" action="{{ route('panel-keywords-delete') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $keyword->id }}">
                                                    </form>
                                                </menu>
                                                <div class="modal js-modal" id="modal-{{ $keyword->id }}" data-animation="on">
                                                    <div class="modal__content" role="alertdialog" tabindex="-1" aria-labelledby="modalTitle1" aria-describedby="modalDescription1">
                                                        <header class="modal__header">
                                                            <h4 class="truncate" id="modalTitle1">{{ __('Edit') }}</h4>
                                                        </header>
                                                        <form action="{{ route('panel-keywords-edit') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $keyword->id }}">
                                                            <div class="modal__body text--right">
                                                                <div class="margin-bottom--sm">
                                                                    <label class="form-label" for="txt-keyword-{{ $keyword->id }}">{{ __('Keyword') }}</label>
                                                                    <input type="text" id="txt-keyword-{{ $keyword->id }}" class="form-control" name="keyword" value="{{ $keyword->keyword }}">
                                                                </div>
                                                                <div class="margin-bottom--sm">
                                                                    <label class="form-label" for="txt-replace-{{ $keyword->id }}">{{ __('Replace') }}</label>
                                                                    <input type="text" id="txt-replace-{{ $keyword->id }}" class="form-control" name="replace" placeholder="{{ __('Keyword replace. For remove keyword leave it blank') }}" value="{{ $keyword->replace }}">
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
                            @if(count($keywords))
                            {!! $keywords->links('extensions.pagination') !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col--lg-5">
                    <form method="POST" action="{{ route('panel-keywords-add') }}">
                        @csrf
                        <fieldset class="margin-bottom--md">
                            <legend class="form-legend">{{ __('Add Keyword') }}</legend>
                            <div class="margin-bottom--sm">
                                <label class="form-label" for="txt-keyword">{{ __('Keyword') }}</label>
                                <input type="text" id="txt-keyword" class="form-control" name="keyword" value="{{ old('keyword') }}">
                            </div>
                            <div class="margin-bottom--sm">
                                <label class="form-label" for="txt-replace">{{ __('Replace') }}</label>
                                <input type="text" id="txt-replace" class="form-control" name="replace" placeholder="{{ __('Keyword replace. For remove keyword leave it blank') }}" value="{{ old('replace') }}">
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
