<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="field-{{$name}}">{{$title}}</label>
    @endif

    <article>
        <div class="medium-editable wrapper b" style="min-height: 500px" id="medium-{{$lang}}-{{$slug}}">
            {!! $value or old($name) !!}
        </div>
    </article>

 <input type="hidden" id="field-{{$lang}}-{{$slug}}"
        @if(isset($prefix))
        name="{{$prefix}}[{{$lang}}]{{$name}}"
        @else
        name="{{$lang}}{{$name}}"
        @endif
        value="{!! $value or old($name) !!}">

    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif

</div>

<div class="line line-dashed b-b line-lg"></div>


@push('scripts')
    <script>
    $(function () {
        var editor{{$lang}}{{$slug}} = new MediumEditor('#medium-{{$lang}}-{{$slug}}',{
            placeholder: {
                text: '{{$placeholder or ''}}',
                hideOnClick: true
            }
        });

        editor{{$lang}}{{$slug}}.subscribe('editableInput', function (event, editable) {
            $('#field-{{$lang}}-{{$slug}}').val($(editable).html());
        });
    });
</script>
@endpush
