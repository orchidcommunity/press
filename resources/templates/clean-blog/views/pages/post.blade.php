@extends(config('press.view').'layouts.app')

@section('title',$post->getContent('title'))
@section('keywords',$post->getContent('keywords'))
@section('description',$post->getContent('description'))

@if (!is_null($post->getContent('picture')))
    @section('head_image',$post->getContent('picture'))
@endif

@section('author')
    <span class="meta">{{__('Posted by')}}
        <a href="#">{{ $post->getUser()->name }}</a>
        on {{$post->publish_at->diffForHumans()}}
    </span>
@endsection

@section('content')

    <!-- Page Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    {!! $post->getContent('body') !!}
                    <hr>
                    <!-- Tags -->
                    <div class="flex center">
                        @foreach($post->tags as $tag)
                            <a href="{{route('tag.posts',$tag->slug)}}"><span class="badge badge-pill badge-dark">{{ $tag->name }}</span></a>
                        @endforeach
                    </div>

                    {{-- Comments --}}
                    {{-- @include(config('press.view').'partials.comment.comments',['comments' => $comments]) --}}
                </div>
            </div>
        </div>
    </article>

@endsection