<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
	   title="{{__('Categories')}}"
	   role="button" aria-haspopup="true" aria-expanded="false">{{__('Categories')}}</a>
	<div class="dropdown-menu">
		@foreach($category as $item)
			<a class="dropdown-item" href="{{route('category.posts',$item->term->slug)}}">{{$item->term->getContent('name')}}</a>
		@endforeach
	</div>
</li>