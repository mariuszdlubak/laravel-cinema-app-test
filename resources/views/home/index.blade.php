<x-layout>
    <div class="pt-28 w-full flex flex-col items-center">
        <div class="w-full">
            <x-slide-show :class="'w-full h-56 sm:h-72 md:h-96 lg:h-[30rem]'" :$baners :$links />
        </div>
        <x-main-box>
            <div class="w-full px-4">
                <x-title>New movies</x-title>
                <div class="flex flex-col">
                    @forelse ($movies as $movie)
                        <x-home-movie-card :$movie  />
                    @empty
                        <div class="py-8 flex justify-center tracking-wider text-text-200">
                            No movies found
                        </div>
                    @endforelse
                </div>
                <x-title>Popular this week</x-title>
                <div class="flex flex-col">
                    @forelse ($movies as $rating => $movie)
                        <x-popular-movie-card :rating="$rating + 1" :$movie />
                    @empty
                        <div class="py-8 flex justify-center tracking-wider text-text-200">
                            No movies found
                        </div>
                    @endforelse
                </div>
            </div>
        </x-main-box>
    </div>
</x-layout>
