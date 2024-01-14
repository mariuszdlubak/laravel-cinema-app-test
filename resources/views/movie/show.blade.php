<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Movies' => route('movies.index'), $movie->title => '#']" />

        <div class="w-full h-56 sm:h-96">
            <img
                src="{{ asset('storage/' . $movie->baner_path) }}"
                alt="{{ $movie->title }} baner"
                class="rounded-md object-cover w-full h-full"
            />
        </div>
        <div>
            <x-title>{{ $movie->title }}</x-title>
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                <div class="w-48 h-72">
                    <img
                        src="{{ asset('storage/' . $movie->icon_path) }}"
                        alt="{{ $movie->title }} icon"
                        class="rounded-md object-cover w-full h-full"
                    />
                </div>
                <div class="sm:w-80 sm:grow text-text-200">
                    <div class="mb-4 flex justify-between">
                        <div class="flex items-center bg-bg-200 rounded-md shadow-md">
                            <div class="p-2 bg-bg-300 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#e0e0e0" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>
                            </div>
                            <div class="px-2 flex flex-col">
                                <span class="text-xs font-bold tracking-wider text-text-200">RELEASE DATE</span>
                                <span class="text-sm">{{ date('Y.m.d', strtotime($movie->release_date)) }}</span>
                            </div>
                        </div>
                        <div class="flex items-center bg-bg-200 rounded-md shadow-md">
                            <div class="p-2 bg-bg-300 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#e0e0e0" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="px-2 flex flex-col">
                                <span class="text-xs font-bold tracking-wider text-text-200">DURATION</span>
                                <span class="text-sm">{{ floor($movie->duration / 60) }}h {{ $movie->duration % 60 }}min</span>
                            </div>
                        </div>
                    </div>
                    <p class="break-all">
                        {{ $movie->description }}
                    </p>
                </div>
            </div>

            <x-title>Additional information about {{ $movie->title }}</x-title>
            <div class="flex flex-col md:flex-row gap-4">
                <div class="md:w-40 md:grow flex flex-col items-start gap-2">
                    <div class="flex items-center bg-bg-200 rounded-md shadow-md">
                        <div class="p-2 bg-bg-300 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#e0e0e0" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                            </svg>
                        </div>
                        <div class="px-2 flex flex-col">
                            <span class="text-sm font-bold tracking-wider text-text-200">Fascinating fact</span>
                        </div>
                    </div>
                    <p class="break-all">
                        {{ $movie->fun_fact }}
                    </p>
                </div>
                <table class="md:w-40 md:grow text-sm tracking-wide text-text-200">
                    <tr class="bg-bg-200">
                        <td class="px-2 py-1 font-semibold">Release date</td>
                        <td class="px-2 py-1">{{ date('Y.m.d', strtotime($movie->release_date)) }}</td>
                    </tr>
                    <tr class="bg-bg-300">
                        <td class="px-2 py-1 font-semibold">Duration</td>
                        <td class="px-2 py-1">{{ $movie->duration }}</td>
                    </tr>
                    <tr class="bg-bg-200">
                        <td class="px-2 py-1 font-semibold">Genre</td>
                        <td class="px-2 py-1">{{ $movie->genre }}</td>
                    </tr>
                    <tr class="bg-bg-300">
                        <td class="px-2 py-1 font-semibold">Cast</td>
                        <td class="px-2 py-1">{{ $movie->cast }}</td>
                    </tr>
                    <tr class="bg-bg-200">
                        <td class="px-2 py-1 font-semibold">Director</td>
                        <td class="px-2 py-1">{{ $movie->director }}</td>
                    </tr>
                    <tr class="bg-bg-300">
                        <td class="px-2 py-1 font-semibold">Production</td>
                        <td class="px-2 py-1">{{ $movie->production }}</td>
                    </tr>
                    <tr class="bg-bg-200">
                        <td class="px-2 py-1 font-semibold">Original language</td>
                        <td class="px-2 py-1">{{ $movie->original_language }}</td>
                    </tr>
                    <tr class="bg-bg-300">
                        <td class="px-2 py-1 font-semibold">Age restrictions</td>
                        <td class="px-2 py-1">{{ $movie->age_restrictions }}</td>
                    </tr>
                </table>
            </div>

            <x-title>Trailer</x-title>
            <div class="w-full flex justify-center">
                <iframe
                    class="w-full aspect-video rounded-lg overflow-hidden"
                    src="{{ $movie->trailer_path }}"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen
                ></iframe>
            </div>

            <x-title>Buy a ticket</x-title>
            <div>
                @forelse ($groupedSchedules as $date => $types)
                    <div class="mb-4">
                        <span class="my-1 text-lg font-bold tracking-wider text-text-200">{{ $date }}</span>
                        @foreach ($types as $type => $schedules)
                            <div class="mb-2 flex flex-col">
                                <div class="pb-1">
                                    <span class="pb-1 font-semibold">{{ explode('|', $type)[0] }}</span>
                                    <span class="ml-3 pl-2 text-xs border-l-2 border-bg-300 tracking-wide">{{ Str::upper(explode('|', $type)[1]) }}</span>
                                </div>
                                <div class="flex items-center flex-wrap gap-2 border-t border-bg-300 pt-2">
                                    @foreach ($schedules as $schedule)
                                        @if ($tickets->where('movie_schedule_id', $schedule->id)->count() < $cinemaHalls->where('id', $schedule->cinema_hall_id)->first()->cinemaSeats->where('blocked', 0)->count() && \Carbon\Carbon::parse($schedule->date)->addMinutes(30)->isFuture())
                                            <a href="{{ route('ticket.buy', ['movieSchedule' => $schedule]) }}" class="px-1 sm:px-2.5 py-0.5 sm:py-1.5 text-xs sm:text-sm md:text-base rounded-sm font-semibold tracking-wide bg-accent-100 hover:bg-accent-200 duration-200 text-gray-950">{{ date('H:i', strtotime($schedule->date)) }}</a>
                                        @else
                                            <div class="px-1 sm:px-2.5 py-0.5 sm:py-1.5 text-xs sm:text-sm md:text-base rounded-sm font-semibold tracking-wide bg-accent-100/20 text-gray-950">{{ date('H:i', strtotime($schedule->date)) }}</div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <span class="text-text-200">Tickets are currently unavailable</span>
                @endforelse
            </div>
        </div>
    </x-main-with-box>
</x-layout>
