@extends(config('press.view').'layouts.app')

@section('content')



	    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
          <h1 class="my-4">{{ $category->term->getContent('name') }}
            <small>{!!  $category->term->getContent('body') !!}</small>
          </h1>
		
          
		 
		@foreach($category->posts as $post)
		<!-- Blog Post -->
		   <div class="card mb-4">
			<h2 class="card-title m-2"><a href="{{route('blog.post',$post->slug)}}" class="h2">{{$post->getContent('name')}}</a></h2>
            <img class="card-img-top" src="{{$post->getContent('picture')}}" alt="Card image cap">
            <div class="card-body">
              <p class="card-text">{{ str_limit(strip_tags($post->getContent('body')),150) }}</p>
              <a href="{{route('blog.post',$post->slug)}}" class="btn btn-primary">Read More &rarr;</a>
            </div>
            <div class="card-footer text-muted">
				Опубликованно: {{$post->publish_at->diffForHumans()}}
            </div>
          </div>
		@endforeach

          <!-- Pagination -->
		  {{-- $category->posts->links('partials.pagination') --}}

        </div>



@endsection