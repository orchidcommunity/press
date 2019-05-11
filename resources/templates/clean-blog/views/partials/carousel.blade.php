<!-- Carousel -->
@if ($post->attachment('image')->get()->count()>0)
<div class="row">
	<div id="carouselExampleIndicators" class="carousel slide mx-auto col-10" data-ride="carousel">
	  <ol class="carousel-indicators">
		@foreach($post->attachment('image')->get() as $image)
			<li data-target="#carouselExampleIndicators" data-slide-to="{{$loop->index}}" {{($loop->first) ? 'class="active"' : ''}} ></li>
		@endforeach
	  </ol>
	  <div class="carousel-inner" role="listbox">
		@foreach($post->attachment('image')->get() as $image)
			<div class="carousel-item {{($loop->first) ? 'active' : ''}}">
			  <img class="d-block img-fluid" src="{{$image->url('standart')}}" alt="{{$image->alt}}">
			    <div class="carousel-caption d-none d-md-block">
				<h3>{{$image->alt}}</h3>
				<p>{{$image->description}}</p>
			  </div>
			</div>
		@endforeach
	  </div>
	  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	  </a>
	</div>
</div>
@endif