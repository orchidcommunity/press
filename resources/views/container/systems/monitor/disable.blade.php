@extends('dashboard::layouts.dashboard')


@section('title',trans('cms::systems/monitor.Monitor'))
@section('description',trans('cms::systems/monitor.description'))



@section('content')


    <!-- main content  -->
    <section class="wrapper-lg bg-white col-md-6">


        <div class="jumbotron text-center bg-white not-found">
            <div>
                <h3 class="font-thin">{{trans("cms::systems/monitor.disabled")}}</h3>
            </div>
        </div>

    </section>

@endsection
