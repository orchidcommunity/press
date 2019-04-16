@extends(config('press.view').'layouts.app')

@section('content')
	    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-lg-8 col-md-10 mx-auto">
		@foreach($posts as $post)
            <!-- Blog Post -->
            <div class="post-preview">
                <a href="{{route('press.post',[config('press.post.prefix'),$post->slug])}}">
                    <h2 class="post-title">
                        {{$post->getContent('input')}}
                    </h2>
                    <h3 class="post-subtitle">
                        {{$post->getContent('description')}}
                    </h3>
                </a>
                <p class="post-meta">{{ __('Posted by')}}
                    <a href="#">{{ $post->getUser()->name }}</a>
                    on {{$post->publish_at->diffForHumans()}}</p>
            </div>
            <hr>
		@endforeach

          <!-- Pagination -->
		  {{ $posts->links(config('press.view').'partials.pagination') }}

        </div>
      </div>
    </div>

@endsection