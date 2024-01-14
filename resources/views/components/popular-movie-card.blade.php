<div>
    <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="p-4 flex items-center space-x-6 rounded-md hover:bg-bg-200/30">
        <div class="w-10 flex justify-center">
            @if ($rating === 1)
                <span class="text-2xl sm:text-3xl text-accent-100">
                    #{{ $rating }}
                </span>
            @elseif ($rating === 2)
                <span class="text-xl sm:text-2xl text-accent-200">
                    #{{ $rating }}
                </span>
            @elseif ($rating === 3)
                <span class="text-xl sm:text-2xl text-accent-200">
                    #{{ $rating }}
                </span>
            @else
                <span class="text-lg sm:text-xl">
                    #{{ $rating }}
                </span>
            @endif
        </div>
        <div class="min-w-[2.5rem] w-10 sm:w-16 h-16 sm:h-24">
            <img
                src="{{ asset('storage/' . $movie->icon_path) }}"
                alt="{{ $movie->title }} icon"
                class="rounded-md object-cover w-full h-full"
            />
        </div>
        <span class="mb-2 text-sm sm:text-lg md:text-xl tracking-wider font-medium">{{ Str::upper($movie->title) }}</span>
    </a>
    <hr class="mx-4 border-bg-300" />
</div>
