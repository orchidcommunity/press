@category('menu')

@foreach($menu as $item)
	@if($item->children->count() > 0)
	  <li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" 
			title="{{$item->title}}"
			target="{{$item->target}}"
			rel="{{$item->robot}}"
		role="button" aria-haspopup="true" aria-expanded="false">{{$item->label}}</a>
		<div class="dropdown-menu">
			@include(config('press.view').'widgets.menu.dropdown',[
					'menu' => $item->children
					])
		</div>
	  </li>
	@else
		<li class="nav-item">
		  <a class="nav-link {{$item->style}}" 
			href="{{$item->slug}}"                  
			title="{{$item->title}}"
			target="{{$item->target}}"
			rel="{{$item->robot}}"
		  >
		  {{$item->label}}
		  </a>
		</li>
	@endif
@endforeach
