<div class="form-group">
    <label class="control-label">{{trans('cms::common.filters.search')}}</label>
    <input type="text" name="search" value="{{$request->get('search')}}"
           placeholder="{{trans('cms::common.search_posts')}}" class="form-control" maxlength="200"
           autocomplete="off">
</div>
