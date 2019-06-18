<div data-post-id="{{$post->id}}" class="row">
    <!-- hbox layout -->
    <div class="hbox hbox-auto-xs no-gutters">
    @if(count($type->fields()) > 0)
        <!-- column -->
            <div class="hbox-col">
                <div class="vbox">
                    <div class="wrapper">
                        <div class="tab-content">
                            @foreach($locales as $code => $lang)
                                <div class="tab-pane @if($loop->first) active @endif" id="local-{{$code}}"
                                     role="tabpanel">
                                    {!! generate_form($type->fields(), $post->toArray(), $code, 'content') !!}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- /column -->
    @endif
    <!-- column -->
        <div class="hbox-col wi-col">
            <div class="vbox">
                <div class="row-row">
                    <div class="wrapper">
                        <div
                                data-controller="screen--tabs"
                                data-screen--tabs-slug="entyti-tab"
                        >
                            <div class="nav-tabs-alt">
                                <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active "
                                               data-action="screen--tabs#setActiveTab"
                                               data-target="#tab-main"
                                               id="button-tab-main"
                                               role="tab"
                                               data-toggle="tab">
                                                {!! _('Main') !!}
                                            </a>
                                        </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           data-action="screen--tabs#setActiveTab"
                                           data-target="#tab-options"
                                           id="button-tab-options"
                                           role="tab"
                                           data-toggle="tab">
                                            {!! _('Options') !!}
                                        </a>
                                    </li>

                                </ul>
                            </div>

                            <!-- main content -->
                            <section>
                                <div class="no-border-xs">
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active"
                                             id="tab-main">

                                            <div class="padder-v">
                                                {!! generate_form($type->main(), $post->toArray()) !!}

                                                @include('press::container.posts.locale')
                                            </div>

                                        </div>
                                        <div role="tabpanel" class="tab-pane @if ($loop->first) active @endif"
                                             id="tab-options">

                                            <div class="padder-v">
                                                {!! generate_form($type->options(), $post->toArray(), null, 'options') !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /column -->
    </div>
</div>
