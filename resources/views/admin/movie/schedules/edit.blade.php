<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Admin Panel' => route('admin.index'), 'Movies Management' => route('admin.movies.index'), $movie->title => route('admin.movies.edit', $movie), 'Schedules' => route('admin.movies.schedules.index', $movie), 'Edit schedule' => '#']" />

        <x-title>Edit schedule for {{ $movie->title }}</x-title>

        <h2 class="text-center text-lg font-semibold tracking-widest">
            Settings
        </h2>

        <div x-data="{ loading: {{ $errors->any() ? 'true' : 'false' }}, sending: false }">
            <form action="{{ route('admin.movies.schedules.edit', ['movie' => $movie, 'schedule' => $schedule]) }}" method="GET" x-ref="settings">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex justify-center">
                        <div class="w-80">
                            <label for="cinema_hall" class="block mb-1 font-medium text-text-200 tracking-wide">Cinema Hall</label>
                            <select
                                name="cinema_hall"
                                id="cinema_hall"
                                x-on:change="loading = true; $refs.settings.submit()"
                                @class([
                                    'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-40 focus:ring-2 bg-bg-200 cursor-pointer',
                                    'ring-slate-300' => !$errors->has('cinema_hall'),
                                    'ring-red-500' => $errors->has('cinema_hall')
                                ])
                            >
                                @php
                                    $selectedHall = strval($schedule->cinema_hall_id);
                                    if(request('cinema_hall')) $selectedHall = request('cinema_hall');
                                    if(old('cinema_hall')) $selectedHall = old('cinema_hall');
                                @endphp
                                @foreach ($cinemaHalls as $hall)
                                    <option value="{{ $hall->id }}" @if($selectedHall === strval($hall->id)) selected @endif>
                                        {{ "Hall: " . $hall->name . " → Seats: " . $hall->cinema_seats_count }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cinema_hall')
                                <div class="mt-1 text-xs text-red-500 tracking-wide">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <div class="w-80">
                            <label for="movie_type" class="block mb-1 font-medium text-text-200 tracking-wide">Movie Type</label>
                            <select
                                name="movie_type"
                                id="movie_type"
                                x-on:change="loading = true; $refs.settings.submit()"
                                @class([
                                    'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-40 focus:ring-2 bg-bg-200 cursor-pointer',
                                    'ring-slate-300' => !$errors->has('movie_type'),
                                    'ring-red-500' => $errors->has('movie_type')
                                ])
                            >
                                @php
                                    $selectedType = strval($schedule->movie_type_id);
                                    if(request('movie_type')) $selectedType = request('movie_type');
                                    if(old('movie_type')) $selectedType = old('movie_type');
                                @endphp

                                @foreach ($movieTypes as $type)
                                    <option value="{{ $type->id }}" @if($selectedType === strval($type->id)) selected @endif>
                                        {{ $type->type . " | " . $type->language }}
                                    </option>
                                @endforeach
                            </select>
                            @error('movie_type')
                                <div class="mt-1 text-xs text-red-500 tracking-wide">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <div class="w-80">
                            <label for="price" class="block mb-1 font-medium text-text-200 tracking-wide">Ticket price</label>
                            <input
                                type="number"
                                name="price"
                                value="{{ old('price', request('price') ? request('price') : $schedule->price) }}"
                                id="price"
                                min="1"
                                max="500"
                                step="0.01"
                                x-on:blur="formatNumber"
                                x-on:change="loading = true"
                                @class([
                                    'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-40 focus:ring-2 bg-bg-200',
                                    'ring-slate-300' => !$errors->has('price'),
                                    'ring-red-500' => $errors->has('price')
                                ])
                            />
                            @error('price')
                                <div class="mt-1 text-xs text-red-500 tracking-wide">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <div class="w-80">
                            <label for="start_date" class="block mb-1 font-medium text-text-200 tracking-wide">Date</label>
                            <input
                                type="date"
                                name="start_date"
                                value="{{ old('start_date', request('start_date') ? request('start_date') : \Carbon\Carbon::parse($schedule->date)->format('Y-m-d')) }}"
                                id="start_date"
                                min="{{ now()->toDateString() }}"
                                max="{{ now()->addMonths(2)->toDateString() }}"
                                x-on:change="loading = true"
                                x-on:blur="$refs.settings.submit()"
                                @class([
                                    'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-40 focus:ring-2 bg-bg-200',
                                    'ring-slate-300' => !$errors->has('start_date'),
                                    'ring-red-500' => $errors->has('start_date')
                                ])
                            />
                            @error('start_date')
                                <div class="mt-1 text-xs text-red-500 tracking-wide">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
            <x-title>Available hours</x-title>

            <div class="flex flex-col relative">
                <x-loader :x-show="'loading'" />

                <form action="{{ route('admin.movies.schedules.update', ['movie' => $movie, 'schedule' => $schedule]) }}" method="POST" x-ref="updateSchedule">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="cinema_hall" value="{{ old('cinema_hall', request('cinema_hall') ? request('cinema_hall') : $schedule->cinema_hall_id) }}" />
                    <input type="hidden" name="movie_type" value="{{ old('movie_type', request('movie_type') ? request('movie_type') : $schedule->movie_type_id) }}" />
                    <input type="hidden" name="price" value="{{ old('price', request('price') ? request('price') : $schedule->price) }}" />
                    <input type="hidden" name="start_date" value="{{ old('start_date', request('start_date') ? request('start_date') : \Carbon\Carbon::parse($schedule->date)->format('Y-m-d')) }}" />
                    <div class="py-4 flex flex-wrap gap-4 justify-center">
                        @php
                            if(!request()->has('cinema_hall') || (request()->has('cinema_hall') && (request('cinema_hall') === strval($schedule->cinema_hall_id) && (!request()->has('start_date') || (request()->has('start_date') && request('start_date') === \Carbon\Carbon::parse($schedule->date)->format('Y-m-d')))))) {
                                $currentHour = ltrim(\Carbon\Carbon::parse($schedule->date)->format('H:i'), '0');
                            }
                        @endphp

                        @forelse ($availableHours as $hour)
                            <div class="flex items-center justify-between">
                                <input
                                    type="radio"
                                    name="hour"
                                    value="{{ $hour }}" id="{{ $hour }}"
                                    x-on:change="sending = true; $refs.updateSchedule.submit()"
                                    class="hidden"
                                />
                                <label
                                    for="{{ $hour }}"
                                    @class([
                                        'flex items-center rounded-md hover:opacity-80 cursor-pointer',
                                        'bg-bg-300' => !isset($currentHour) || (isset($currentHour) && $hour !== $currentHour),
                                        'bg-bg-200' => isset($currentHour) && $hour === $currentHour
                                    ])
                                >
                                    <span class="w-16 text-text-200 flex justify-center">{{ $hour }}</span>
                                    <div
                                        @class([
                                            'p-1.5 rounded-md',
                                            'bg-bg-200' => !isset($currentHour) || (isset($currentHour) && $hour !== $currentHour),
                                            'bg-accent-100' => isset($currentHour) && $hour === $currentHour
                                        ])
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                </label>
                            </div>
                        @empty
                            <div class="py-8 flex justify-center tracking-wider text-text-200">
                                <p>The selected cinema hall has no available slots at the chosen time</p>
                            </div>
                        @endforelse
                    </div>
                </form>
            </div>
            <x-loading :x-show="'sending'">The schedule update is in progress</x-loading>
        </div>
    </x-main-with-box>
    <script>
        function formatNumber(event) {
            let input = event.target;
            if(input.value > 500) input.value = 500;
            if(input.value < 1) input.value = 1;
            input.value = parseFloat(input.value).toFixed(2);
            this.$refs.settings.submit();
        }
    </script>
</x-layout>
