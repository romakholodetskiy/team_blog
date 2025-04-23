{{--@dd($ratings);--}}
@if($ratings->isEmpty())
    <p class="text-gray-600">Немає нових лайків.</p>
@else
    <form method="POST" action="{{ route('profile.markRead') }}">
        @csrf
        <button type="submit" name="mark_all" class="mb-4 bg-blue-500 text-white px-3 py-1 rounded">
            ✓ Позначити все як прочитане
        </button>

        <ul class="space-y-2">
            @foreach ($ratings as $rating)
                <li>
                    <label>
                        <input type="checkbox" name="read_items[]" value="rating_{{ $rating->id }}">
                        <strong>{{ $rating->user->name }}</strong> поставив лайк на ваш пост
                        <a href="{{ route('post.show', $rating->post->id) }}" class="text-blue-500">
                            {{ $rating->post->name }}
                        </a>
                    </label>
                </li>
            @endforeach
        </ul>
    </form>
@endif

