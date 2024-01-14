<div>
    <div class="pr-4 flex items-center justify-between space-x-4 rounded-md hover:bg-bg-200/30">
        <a href="{{ route('admin.movies.edit', ['movie' => $movie]) }}" class="p-4 w-10 grow flex items-center space-x-2 sm:space-x-6">
            <div class="w-10 min-w-[2.5rem] flex justify-center">
                <span class="text-base md:text-lg text-text-200">
                    {{ $movie->id }}
                </span>
            </div>
            <div class="min-w-[2rem] w-8 md:w-16 h-12 md:h-24">
                <img
                    src="{{ asset('storage/' . $movie->icon_path) }}"
                    alt="{{ $movie->title }} icon"
                    class="rounded-md object-cover w-full h-full"
                />
            </div>
            <span class="mb-2 text-xs sm:text-lg md:text-xl tracking-wider font-medium break-all">{{ Str::upper($movie->title) }}</span>
        </a>
        <a href="{{ route('admin.movies.schedules.index', $movie) }}" class="px-2 py-1 text-xs md:text-base bg-bg-300 rounded-md hover:opacity-80">Schedules</a>
    </div>
    <hr class="mx-4 border-bg-300" />
</div>
