@extends('cms::layouts.install')

@section('title', trans('cms::install.final.title'))
@section('descriptions', trans('cms::install.final.message'))

@section('container')



    <div class="page-header text-center">
        <h4><i class="fa text-success fa-check-square-o"
               aria-hidden="true"></i> {{trans('cms::install.final.message')}}</h4>
    </div>

    <p class="padder-v">{{ session('message')['message'] }}</p>


    <div class="btn-group btn-group-justified" role="group">
        <a href="/dashboard" class="btn btn-link">{{ trans('cms::install.final.exit') }}</a>
    </div>



@stop
