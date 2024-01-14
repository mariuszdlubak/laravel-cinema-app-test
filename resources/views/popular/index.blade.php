<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Popular' => '#']" />

        <x-title>Popular movies this week</x-title>
        <div class="flex flex-col">
            @forelse ($movies as $rating => $movie)
                <x-popular-movie-card :rating="$rating + 1" :$movie />
            @empty
                <div class="py-8 flex justify-center tracking-wider text-text-200">
                    No movies found
                </div>
            @endforelse
        </div>
    </x-main-with-box>
</x-layout>
