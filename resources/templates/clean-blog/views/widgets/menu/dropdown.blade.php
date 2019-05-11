@foreach($menu as $item)
	<a class="dropdown-item {{$item->style}}" 
			href="{{$item->slug}}"                  
			title="{{$item->title}}"
			target="{{$item->target}}"
			rel="{{$item->robot}}"
		  >
		  {{$item->label}}
		  </a>
@endforeach
