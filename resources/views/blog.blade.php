<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div>
            <a href="{{ route('post.create') }}">Create new post</a>
        </div>

        @forelse ($posts as $post)
            <div>
                @if($post->img_link)
                    <img src="{{ asset('storage/' . $post->img_link) }}" alt="">
                @endif

                <h2>
                    <a href="{{ route('post.show', $post->id) }}">
                        {{ $post->name }}
                    </a>
                </h2>

                <p>{{ $post->short_description }}</p>

                <p>
                    <strong>Categories:</strong>
                    @foreach($post->categories as $category)
                        {{ $loop->first ? '' : ',' }} {{ $category->name }}
                    @endforeach
                </p>

                {{-- Лайк / дизлайк --}}
                <div>
                    <i class="fa-solid fa-thumbs-up"></i>
                    <i class="fa-solid fa-thumbs-down"></i>
                </div>

                <a href="{{ route('post.show', $post->id) }}">Go to article</a>

                {{-- Кнопки редагування та видалення --}}
                <div>
                    <a href="{{ route('post.edit', $post->id) }}">Edit</a>

                    <form method="POST" action="{{ route('post.destroy', $post->id) }}"
                          onsubmit="return confirm('Are you sure you want to delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p>No posts available.</p>
        @endforelse

        {{-- Пагінація --}}
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
