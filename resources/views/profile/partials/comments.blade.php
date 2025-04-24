@if($comments->isEmpty())
    <p class="text-gray-600">No new comments</p>
@else
    <form action="{{ route('comment.patch') }}" method="post">
        @csrf
        @method('PATCH')
        <input type="checkbox" name="items[]" value="{{ implode(',', $commentsId) }}">
        <button type="submit" name="mark_all" class="mb-4 bg-blue-500 text-black px-3 py-1 rounded">
            Mark all as read
        </button>
    </form>
        <ul class="space-y-2">
            <form action="{{route('comment.patch')}}" method="post">
                @csrf
                @method('PATCH')
                @foreach ($comments as $comment)
                    <li>
                        <label>
                            <input type="checkbox" name="items[]" value="{{ $comment->id }}">
                            <strong>{{ $comment->user->login }}</strong>
                            <p>{{ ($comment->name) }}</p>
                            <a href="{{ route('post.show', $comment->post->id) }}" class="text-blue-500">
                                {{ $comment->post->name }}
                            </a>
                        </label>
                    </li>
                @endforeach
                <input type="submit" value="mark as read">
            </form>
        </ul>
@endif

