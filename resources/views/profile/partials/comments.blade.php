<h2 class="title">Comments</h2>
@if($comments->isEmpty())
    <p class="subtitle">No new comments</p>
@else
    <form action="{{ route('comment.patch') }}" method="post">
        @csrf
        @method('PATCH')
        @foreach($comments as $comment)
            <input type="hidden" name="items[]" value="{{ $comment->id}}" class="btn-primary">
        @endforeach
        <button type="submit" name="mark_all" class="btn-primary">
            Mark all as read
        </button>
    </form>
        <ul class="space-y-2">
            <form action="{{route('comment.patch')}}" method="post">
                @csrf
                @method('PATCH')
                @foreach ($comments as $comment)
                    <div class="profile-form-container">
                        <li>
                            <label>
                                <input type="checkbox" name="items[]" value="{{ $comment->id }}">
                                <strong>{{ $comment->user->login }}</strong>
                                <p class="subtitle">{{ ($comment->name) }}</p>
                                <a href="{{ route('post.show', $comment->post->id) }}" class="link">
                                    {{ $comment->post->name }}
                                </a>
                            </label>
                        </li>
                    </div>
                @endforeach
                <input type="submit" value="mark as read" class="btn-primary">
            </form>
        </ul>
@endif

