{{-- Comments --}}
		  {{-- dd(Auth::user()) --}}
          <!-- Comments Form -->
		  @if (Auth::user())
          <div class="card my-4">
            <h5 class="card-header">Leave a Comment:</h5>
            <div class="card-body">
              <form>
                <div class="form-group">
                  <textarea class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
		  @endif

@foreach($comments as $comment)
	<div class="media mb-4">
		<img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
		<div class="media-body">
		  <h5 class="mt-0">{{$comment->author->name}} <span class="text-muted small">от {{$comment->updated_at->diffForHumans()}}</span></h5>
		  {{$comment->content}}
		  @if($comment->replies->where('approved', 1)->count() > 0)
			@include('partials.comment.childcomments',['comments' => $comment->replies->where('approved', 1)])
		  @endif
		</div>
	</div>
@endforeach