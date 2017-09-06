@php
    if(!config('platform.install')){
        header("Location: /dashboard");
        die();
    }
@endphp

@extends('dashboard::auth.login')
