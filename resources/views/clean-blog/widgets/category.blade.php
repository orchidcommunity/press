<!-- Categories Widget -->
<div class="card my-4">
<h5 class="card-header">{{ _('Categories') }}</h5>
	<div class="card-body">
	  <div class="row">
		<div class="col">
		  <ul class="list-unstyled mb-0">
		  @foreach($category as $item)
			<li>
			  <a href="{{route('category.posts',$item->term->slug)}}">{{$item->term->getContent('name')}}</a>
			</li>
		  @endforeach
		  </ul>
		</div>
	  </div>
	</div>
</div>