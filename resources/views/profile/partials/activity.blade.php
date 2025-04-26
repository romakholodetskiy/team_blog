<h2 class="title">Ratings</h2>
@if($ratings->isEmpty())
    <p class="subtitle">No new likes.</p>
@else
    <form action="{{ route('rating.patch') }}" method="post">
        @csrf
        @method('PATCH')
        @foreach($ratings as $rating)
            <input type="hidden" name="items[]" value="{{ $rating->id }}">
        @endforeach
        <button type="submit" name="mark_all" class="btn-primary">
            Mark all as read
        </button>
    </form>
        <ul class="space-y-2">
            <form action="{{route('rating.patch')}}" method="post">
                @csrf
                @method('PATCH')
                @foreach ($ratings as $rating)
                    <div class="profile-form-container">
                        <li>
                            <label>
                                <input type="checkbox" name="items[]" value="{{ $rating->id }}">
                                <strong>{{ $rating->user->login }}</strong>
                                @if($rating->liked === 0)
                                    <div class="subtitle">
                                        Disliked your post
                                    </div>
                                @else
                                    <div class="subtitle">
                                        Liked your post
                                    </div>
                                @endif
                                <a href="{{ route('post.show', $rating->post->id) }}" class="link">
                                    {{ $rating->post->name }}
                                </a>
                            </label>
                        </li>
                    </div>
                @endforeach
                <input type="submit" value="mark as read" class="btn-primary">
            </form>
        </ul>
@endif

