{{--@dd($ratings);--}}
@if($ratings->isEmpty())
    <p class="text-gray-600">No new likes.</p>
@else
    <form action="{{ route('rating.patch') }}" method="post">
        @csrf
        @method('PATCH')
        <input type="checkbox" name="items[]" value="{{ implode(',', $ratingsId) }}">
        <button type="submit" name="mark_all" class="mb-4 bg-blue-500 text-black px-3 py-1 rounded">
            Mark all as read
        </button>
    </form>
        <ul class="space-y-2">
            <form action="{{route('rating.patch')}}" method="post">
                @csrf
                @method('PATCH')
                @foreach ($ratings as $rating)
                    <li>
                        <label>
                            <input type="checkbox" name="items[]" value="{{ $rating->id }}">
                            <strong>{{ $rating->user->login }}</strong>
                            @if($rating->liked === 0)
                                <div>
                                    Disliked your post
                                </div>
                            @else
                                <div>
                                    Liked your post
                                </div>
                            @endif
                            <a href="{{ route('post.show', $rating->post->id) }}" class="text-blue-500">
                                {{ $rating->post->name }}
                            </a>
                        </label>
                    </li>
                @endforeach
                <input type="submit" value="mark as read">
            </form>
        </ul>
@endif

