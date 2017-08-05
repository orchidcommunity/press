@extends('cms::layouts.install')

@section('title', trans('cms::install.requirements.title'))
@section('descriptions', trans('cms::install.requirements.message'))

@section('container')


    <label>Server Requirements</label>
    <ul class="list-group center wrapper">
        @foreach($requirements['requirements'] as $extension => $enabled)
            <li class="m-b-sm">
                {{ trans('cms::install.requirements.extensions.'. $extension) }}

                @if($enabled)
                    <i class="icon-check text-success pull-right" aria-hidden="true"></i>
                @else
                    <i class="icon-close text-danger pull-right" aria-hidden="true"></i>
                @endif
            </li>
        @endforeach
    </ul>


    <div class="text-right">
        <a
           @if(!isset($requirements['errors']))
           href="{{ route('install::permissions') }}"
           class="btn btn-link"
           @else
           href="#"
           class="btn btn-danger disable" disabled
                @endif
        >

            {{ trans('cms::install.next') }}
        </a>
    </div>


@stop
