<div>
    <div class="p-4 flex space-x-6">
        <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="w-16 h-24 sm:w-32 sm:h-48 md:w-40 md:h-60">
            <img
                src="{{ asset('storage/' . $movie->icon_path) }}"
                alt="{{ $movie->title }} icon"
                class="rounded-md object-cover w-full h-full hover:opacity-80"
            />
        </a>
        <div class="w-40 grow flex flex-col">
            <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="mb-2 text-sm sm:text-lg md:text-xl tracking-wider font-medium hover:text-text-200 duration-200">{{ Str::upper($movie->title) }}</a>
            <div class="flex items-center space-x-2">
                <div class="w-10 h-5 bg-bg-300 rounded-sm text-xs font-semibold text-gray-950 flex items-center justify-center">{{ $movie->age_restrictions ? ($movie->age_restrictions . '+') : '' }}</div>
                <span class="pr-4 text-xs">{{ $movie->genre }}</span>
                <span class="pl-2 text-xs border-l-2 border-bg-300">{{ floor($movie->duration / 60) }}h {{ $movie->duration % 60 }}min</span>
            </div>
            <div class="mt-2 sm:mt-4 flex flex-col gap-2">
                @foreach ($movie->movieTypes as $movieType)
                    @if (!$movieType->movieSchedules->isEmpty())
                        <div class="flex flex-col">
                            <div class="pb-1">
                                <span class="pb-1 font-semibold">{{ $movieType->type }}</span>
                                <span class="ml-3 pl-2 text-xs border-l-2 border-bg-300 tracking-wide">{{ Str::upper($movieType->language) }}</span>
                            </div>
                            <div class="flex items-center flex-wrap gap-2 border-t border-bg-300 pt-2">
                                @foreach ($movieType->movieSchedules as $movieSchedule)
                                    @if ($tickets->where('movie_schedule_id', $movieSchedule->id)->count() < $cinemaHalls->where('id', $movieSchedule->cinema_hall_id)->first()->cinemaSeats->where('blocked', 0)->count() && \Carbon\Carbon::parse($movieSchedule->date)->addMinutes(30)->isFuture())
                                        <a href="{{ route('ticket.buy', ['movieSchedule' => $movieSchedule]) }}" class="px-1 sm:px-2.5 py-0.5 sm:py-1.5 text-xs sm:text-sm md:text-base rounded-sm font-semibold tracking-wide bg-accent-100 hover:bg-accent-200 duration-200 text-gray-950">{{ date('H:i', strtotime($movieSchedule->date)) }}</a>
                                    @else
                                        <div class="px-1 sm:px-2.5 py-0.5 sm:py-1.5 text-xs sm:text-sm md:text-base rounded-sm font-semibold tracking-wide bg-accent-100/20 text-gray-950">{{ date('H:i', strtotime($movieSchedule->date)) }}</div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <hr class="mx-4 border-bg-300" />
</div>
