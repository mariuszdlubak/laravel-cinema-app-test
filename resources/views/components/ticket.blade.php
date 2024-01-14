<div>
    <div @class([
        'p-4 flex space-x-6',
        'opacity-40' => now() > date('Y-m-d H:i:s', strtotime($ticket->movieSchedule->date) + $ticket->movieSchedule->movieType->movie->duration * 60)
    ])>
        <a href="{{ route('movies.show', ['movie' => $ticket->movieSchedule->movieType->movie]) }}" class="w-16 h-24 sm:w-32 sm:h-48">
            <img
                src="{{ asset('storage/' . $ticket->movieSchedule->movieType->movie->icon_path) }}"
                alt="{{ $ticket->movieSchedule->movieType->movie->title }} icon"
                class="rounded-md object-cover w-full h-full hover:opacity-80"
            />
        </a>
        <div class="w-40 grow">
            <div class="flex items-start justify-between">
                <a href="{{ route('movies.show', ['movie' => $ticket->movieSchedule->movieType->movie]) }}" class="mb-2 text-sm sm:text-lg md:text-xl tracking-wider font-medium hover:text-text-200 duration-200">{{ Str::upper($ticket->movieSchedule->movieType->movie->title) }}</a>
                <div class="flex space-x-2 text-text-200 text-xs sm:text-sm">
                    <span class="pr-2 border-r-2 border-bg-200">{{ $ticket->movieSchedule->movieType->type }}</span>
                    <span>{{ $ticket->movieSchedule->movieType->language }}</span>
                </div>
            </div>
            <div class="w-full pt-2 sm:pt-10 flex justify-between items-start">
                <div class="flex flex-col gap-2">
                    <div class="py-0.5 px-4 flex items-center justify-between rounded-md bg-bg-200 text-xs sm:text-sm text-gray-950 font-semibold">
                        <span>Hall</span>
                        <span class="font-bold">{{ $ticket->cinemaSeat->cinemaHall->name }}</span>
                    </div>
                    <div class="flex items-center rounded-md bg-bg-200 text-xs sm:text-sm text-text-200">
                        <span class="px-4">
                            Seat
                        </span>
                        <span class="px-2 py-1 rounded-md bg-accent-100 text-gray-950 font-semibold">
                            {{ $ticket->cinemaSeat->seat }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <div class="py-0.5 flex items-center justify-center rounded-md bg-bg-200 text-xs sm:text-sm text-gray-950 font-semibold">
                        Date
                    </div>
                    <div class="flex items-center rounded-md bg-bg-200 text-xs sm:text-sm text-text-200">
                        <span class="px-4">
                            {{ date('Y-m-d', strtotime($ticket->movieSchedule->date)) }}
                        </span>
                        <span class="px-2 py-1 rounded-md bg-accent-100 text-gray-950 font-semibold">
                            {{ date('H:i', strtotime($ticket->movieSchedule->date)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="mx-4 border-bg-300" />
</div>
