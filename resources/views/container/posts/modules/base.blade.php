<div class="wrapper-md">
    <div class="form-group">
        <label>{{trans('cms::post/general.semantic_url')}}</label>
        <input type='text' class="form-control"
               value="{{$post->slug or ''}}"
               placeholder="{{trans('cms::post/general.semantic_url_unique_name')}}" name="slug">
    </div>
    <div class="line line-dashed b-b line-lg"></div>
    <div class="form-group">
        <label>{{trans('cms::post/general.time_of_publication')}}</label>
        <div class='input-group date datetimepicker'>
            <input type='text' class="form-control"
                   value="{{$post->publish_at or ''}}"
                   name="publish">
            <span class="input-group-addon">
            <span class="icon-calendar"></span>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label>{{trans('cms::post/general.status')}}</label>
        <select name="status" class="form-control">
            @foreach($type->status() as $key => $value)
                <option value="{{$key}}"
                        @if(!is_null($post) && $post->status == $key) selected @endif >
                    {{$value}}</option>
            @endforeach
        </select>
    </div>
    <div class="line line-dashed b-b line-lg"></div>

    @if(!empty($type->views))
        <div class="form-group">
            <label>{{trans('cms::post/general.view')}}</label>
            <select name="options[view]" class="form-control">
                @foreach($type->views as $key => $value)
                    <option value="{{$key}}"
                            @if(!is_null($post) && $post->getOption('view') == $key) selected @endif >
                        {{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="line line-dashed b-b line-lg"></div>
    @endif

    <div class="form-group">
        <label>{{trans('cms::post/general.tags')}}</label>
        <select class="form-control select2-tags" name="tags[]" multiple="multiple" placeholder="{{trans('cms::post/general.generic_tags')}}">
            @if(!is_null($post))
                @foreach($post->tags as $tag)
                    <option value="{{$tag->name}}" selected="selected">{{$tag->name}}</option>
                 @endforeach
            @endif
        </select>
    </div>

    <div class="line line-dashed b-b line-lg"></div>
    <div class="form-group">
        <label class="control-label">{{trans('cms::post/general.show_in_categories')}}</label>
        <select name="category[]" multiple data-placeholder="{{trans('cms::post/general.select_category')}}"
                class="select2 form-control">
            @foreach($category as  $value)
                <option value="{{$value->id}}"
                        @if($value->active) selected @endif >
                    {{$value->term->getContent('name')}}</option>
            @endforeach
        </select>
    </div>
    <div class="line line-dashed b-b line-lg"></div>
    @if(!is_null($author))
        <p>
            {{trans('cms::post/general.author')}}: <i title="{{$author->email or ''}}">{{$author->name or ''}}</i>
        </p>
        <div class="line line-dashed b-b line-lg"></div>
    @endif
    @if(!is_null($post))
        <p>
            {{trans('cms::post/general.changed')}}: <span
                    title="{{$post->updated_at}}">{{$post->updated_at->diffForHumans()}}</span>
        </p>
        <div class="line line-dashed b-b line-lg"></div>
    @endif
    @if(count($locales) > 1)
        @foreach($locales as $key => $locale)
            <div class="line line-dashed b-b line-lg"></div>
            <div class="form-group">
                <label class="col-sm-6 control-label">{{$locale['native']}}</label>
                <div class="col-sm-6">
                    @if(!is_null($post))
                        <label class="i-switch bg-info m-t-xs m-r">
                            <input type="checkbox" name="options[locale][{{$key}}]"
                                   value="true" {{$post->checkLanguage($key)  ? 'checked' : ''}}>
                            <i></i>
                        </label>
                    @else
                        <label class="i-switch bg-info m-t-xs m-r">
                            <input type="checkbox" name="options[locale][{{$key}}]"
                                   value="true" @if ($loop->first) checked @endif>
                            <i></i>
                        </label>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        @foreach($locales as $key => $locale)
            <input type="hidden" name="options[locale][{{$key}}]"
                   value="true">
        @endforeach
    @endif
</div>


<script>

window.addEventListener("load", function(){
    $('.select2-tags').select2({
        theme: "classic",
        templateResult: function formatState (state) {
            if (!state.id || !state.count) { return state.text; }

            var str ='<span>' + state.text + '</span>' +' <span class="pull-right badge bg-info">' + state.count + '</span>';

            return  $(str);
        },
        createTag: function (tag) {
            return {
                id: tag.term,
                text: tag.term,
            };
        },
        escapeMarkup: function(m) {
            return m;
        },
        width: '100%',
        tags: true,
        cache: true,
        ajax: {
            url: function (params) {
                return '/dashboard/tools/tags/' + params.term;
            },
            delay: 250,
            processResults: function (data, page) {
                return {
                    results: data
                };
            }
        }
    });
});


</script>
