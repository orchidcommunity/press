<div class="form-group input-sort">
    <label>{{$title}}</label>
   <ul id="sortable-{{$slug}}" class="container-fluid">
       @foreach($data as $key => $val)
        <li class="ui-state-default form-group row">
            <span onclick="return false;" class="btn btn-link col-xs-1 pull"><i class="fa-bars fa"></i></span>
            <input type="text" class="form-control col-xs-10" name="{{$prefix}}[{{$lang}}][{{$tag}}][{{$slug}}][{{$key}}]" value="{{$val}}">
            <button class="btn btn-link col-xs-1 remove" onclick="removeitem{{$slug}}(this)"><i class="icon-trash fa"></i></button>
        </li>
       @endforeach
       @if($data === [])
               <li class="ui-state-default form-group row">
                   <span onclick="return false;" class="btn btn-link col-xs-1 pull"><i class="fa-bars fa"></i></span>
                   <input type="text" class="form-control col-xs-10" name="{{$prefix}}[{{$lang}}][{{$tag}}][{{$slug}}][0]">
                   <button class="btn btn-link col-xs-1 remove" onclick="removeitem{{$slug}}(this)"><i class="icon-trash fa"></i></button>
               </li>
       @endif
    </ul>
    <div class="button-group text-center">
        <button onclick="newitem{{$slug}}()" class="btn btn-xs alert-info">Add new</button>
    </div>
</div>
<div class="line line-dashed b-b line-lg"></div>
<style>
    .input-sort li{
        list-style: none;
    }
    .input-sort .form-control {
        width: 83.33333333%;
    }
</style>
@push('scripts')
<script>
    function newitem{{$slug}}() {
        event.preventDefault();
        let item = '<li class="ui-state-default form-group row">\n' +
            '            <span onclick="return false;" class="btn btn-link col-xs-1 pull"><i class="fa-bars fa"></i></span>\n' +
            '            <input type="text" class="form-control col-xs-10" name="" value="">\n' +
            '            <button class="btn btn-link col-xs-1 remove" onclick="removeitem{{$slug}}(this)"><i class="icon-trash fa"></i></button>\n' +
            '        </li>';
        $('#sortable-{{$slug}}').append(item);
        $("#sortable-{{$slug}} li").each(function (li) {
            $(this).find('input').attr({'name': '{{$prefix}}[{{$lang}}][{{$tag}}][{{$slug}}]['+li+']'})
        })
    }
    function removeitem{{$slug}}(item) {
        event.preventDefault();
        $(item).parent().remove();

        $("#sortable-{{$slug}} li").each(function (li) {
            $(this).find('input').attr({'name': '{{$prefix}}[{{$lang}}][{{$tag}}][{{$slug}}]['+li+']'})
        })
    }
    $(function() {
        $( "#sortable-{{$slug}}" ).sortable({
            placeholder: "ui-sortable-placeholder",
            axis: "y",
            update:function(event,ui){
                $("#sortable-{{$slug}} li").each(function (li) {
                    $(this).find('input').attr({'name': '{{$prefix}}[{{$lang}}][{{$tag}}][{{$slug}}]['+li+']'})
                })
            }
        });
    });
</script>
@endpush
