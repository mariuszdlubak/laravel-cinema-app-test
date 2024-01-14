<a href="{{ route('movies.show', ['movie' => $movie]) }}" class="rounded-md hover:bg-bg-200/30">
    <div class="p-4 flex space-x-6">
        <div class="w-16 h-24 sm:w-32 sm:h-48 md:w-40 md:h-60">
            <img
                src="{{ asset('storage/' . $movie->icon_path) }}"
                alt="{{ $movie->title }} icon"
                class="rounded-md object-cover w-full h-full hover:opacity-80"
            />
        </div>
        <div class="w-40 grow flex flex-col">
            <div class="flex items-start justify-between gap-2">
                <span class="mb-2 text-sm sm:text-lg md:text-xl tracking-wider font-medium hover:text-text-200 duration-200">{{ Str::upper($movie->title) }}</span>
                <div class="flex items-center bg-bg-200 rounded-md shadow-md">
                    <div class="p-1 sm:p-2 bg-bg-300 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#e0e0e0" class="w-6 sm:w-8 h-6 sm:h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                        </svg>
                    </div>
                    <div class="px-2 flex flex-col">
                        <div class="hidden sm:block text-xs font-bold tracking-wider text-text-200 whitespace-nowrap">RELEASE DATE</div>
                        <span class="text-xs md:text-sm">{{ date('Y.m.d', strtotime($movie->release_date)) }}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-10 h-5 bg-bg-300 rounded-sm text-xs font-semibold text-gray-950 flex items-center justify-center">{{ $movie->age_restrictions ? ($movie->age_restrictions . '+') : '' }}</div>
                <span class="pr-4 text-xs">{{ $movie->genre }}</span>
                <span class="pl-2 text-xs border-l-2 border-bg-300">{{ floor($movie->duration / 60) }}h {{ $movie->duration % 60 }}min</span>
            </div>
            <div class="overflow-hidden">
                <p class="mt-4 hidden md:block text-text-200 line-clamp-2">
                    {{ $movie->description }}
                </p>
            </div>
        </div>
    </div>
    <hr class="mx-4 border-bg-300" />
</a>
