<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Admin Panel' => route('admin.index'), 'Movies Management' => route('admin.movies.index'), $movie->title => route('admin.movies.edit', $movie), 'Schedules' => '#']" />

        <x-title>Schedules Management for {{ $movie->title }}</x-title>
        <div x-data="{ loading: false }">
            <div class="mb-4 flex items-center justify-between gap-4">
                <a
                    href="{{ request()->has('upcoming_only') ? route('admin.movies.schedules.index', ['movie' => $movie]) : route('admin.movies.schedules.index', ['movie' => $movie, 'upcoming_only' => 'true']) }}"
                    class="flex items-center gap-2 cursor-pointer"
                    x-on:click="loading = true"
                >
                    <input
                        type="checkbox"
                        class="accent-accent-100"
                        @if(request()->has('upcoming_only')) checked @endif
                    />
                    <span class="text-text-200">Show only upcoming movie screenings</span>
                </a>
                <a href="{{ route('admin.movies.types.create', ['movie' => $movie]) }}" class="flex items-center bg-bg-200 rounded-md hover:opacity-80">
                    <div class="p-1 bg-accent-100 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <span class="px-2 text-text-200 whitespace-nowrap">Add new type</span>
                </a>
            </div>
            <div class="flex flex-col gap-6 relative">
                <x-loader :x-show="'loading'" />

                @forelse ($types as $type)
                    <div class="flex flex-col gap-2">
                        <div class="pb-1 border-b border-bg-300 text-lg flex items-center justify-between">
                            <div>
                                <span class="pb-1 font-semibold">{{ $type->type }}</span>
                                <span class="ml-3 pl-2 border-l-2 border-bg-300 tracking-wide">{{ Str::upper($type->language) }}</span>
                            </div>
                            <div>
                                <a href="{{ route('admin.movies.types.edit', ['movie' => $movie, 'type' => $type]) }}" class="hover:opacity-80">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @foreach ($type->movieSchedules as $day => $schedules)
                            <div class="flex flex-col gap-1">
                                <span class="text-md font-medium tracking-widest">{{ $day }}</span>
                                <div class="flex gap-2 flex-wrap">
                                    @foreach ($schedules as $schedule)
                                        <a
                                            href="{{ route('admin.movies.schedules.edit', ['movie' => $movie, 'schedule' => $schedule]) }}"
                                            class="bg-bg-300 flex items-center shadow-md rounded-md"
                                        >
                                            <div class="w-8 h-8 bg-bg-200 flex items-center justify-center rounded-md font-medium">
                                                {{ $schedule->cinemaHall->name }}
                                            </div>
                                            <span class="px-2 text-gray-950 font-semibold tracking-wider">
                                                {{ date('H:i', strtotime($schedule->date)) }}
                                            </span>
                                        </a>
                                    @endforeach
                                    @if(\Carbon\Carbon::parse($schedule->date)->greaterThanOrEqualTo(\Carbon\Carbon::now()) && \Carbon\Carbon::parse($schedule->date)->lessThanOrEqualTo(\Carbon\Carbon::now()->addMonths(2)))
                                        <a href="{{ route('admin.movies.schedules.create', ['movie' => $movie, 'movie_type' => $type->id, 'start_date' => $day]) }}" class="w-8 h-8 bg-bg-200 flex items-center justify-center shadow-md rounded-md font-bold hover:opacity-80">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="flex justify-start">
                            <a href="{{ route('admin.movies.schedules.create', ['movie' => $movie, 'movie_type' => $type->id]) }}" class="mt-2 h-8 px-4 bg-bg-200 flex items-center shadow-md rounded-md hover:opacity-80">
                                Add new
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 flex justify-center tracking-wider text-text-200">
                        No schedules found
                    </div>
                @endforelse
            </div>
        </div>
    </x-main-with-box>
</x-layout>
