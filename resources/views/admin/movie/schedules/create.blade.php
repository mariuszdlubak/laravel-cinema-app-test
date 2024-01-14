<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Admin Panel' => route('admin.index'), 'Movies Management' => route('admin.movies.index'), $movie->title => route('admin.movies.edit', $movie), 'Schedules' => route('admin.movies.schedules.index', $movie), 'New schedule' => '#']" />

        <x-title>Add new schedule for {{ $movie->title }}</x-title>

        <h2 class="text-center text-lg font-semibold tracking-widest">
            Settings
        </h2>

        <div x-data="{ loading: {{ $errors->any() ? 'true' : 'false' }}, sending: false }">
            <form action="{{ route('admin.movies.schedules.create', ['movie' => $movie]) }}" method="GET" x-ref="settings">
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
                                    $selectedHall = $cinemaHalls->first()->id;
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
                                    $selectedType = $movieTypes->first()->id;
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
                                value="{{ old('price', request('price') ? request('price') : 5) }}"
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

                    <div class="flex flex-col items-center gap-2">
                        <div class="w-80">
                            <label for="start_date" class="block mb-1 font-medium text-text-200 tracking-wide">Date</label>
                            <input
                                type="date"
                                name="start_date"
                                value="{{ old('start_date', request('start_date') ? request('start_date') : now()->toDateString()) }}"
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
                        <div class="flex flex-col gap-2" x-data="{ repeat: {{ old('repeat') === 'on' || request('repeat') === 'on' ? 'true' : 'false' }} }">
                            <div class="w-80 flex items-center gap-2">
                                <input type="checkbox" name="repeat" id="repeat" class="accent-accent-100 cursor-pointer" x-on:change="repeat = !repeat; loading = true; $refs.settings.submit()" @if(old('repeat') === 'on' || request('repeat') === 'on') checked @endif />
                                <label for="repeat" class="text-text-200 tracking-wide select-none">Repeat</label>
                            </div>
                            <div x-show="repeat">
                                <div class="w-80 flex items-center gap-2" x-show="repeat">
                                    <label for="days" class="text-text-200 tracking-wide select-none whitespace-nowrap">Repeat every</label>
                                    <input
                                        type="number"
                                        name="days"
                                        value="{{ old('days', request('days') ? request('days') : 7) }}"
                                        id="days"
                                        min="1"
                                        max="14"
                                        x-on:change="loading = true"
                                        x-on:blur="$refs.settings.submit()"
                                        @class([
                                            'w-20 rounded-md border-0 py-1 px-2.5 text-sm ring-1 placeholder:text-slate-40 focus:ring-2 bg-bg-200',
                                            'ring-slate-300' => !$errors->has('days'),
                                            'ring-red-500' => $errors->has('days')
                                        ])
                                    />
                                    <label for="days" class="text-text-200 tracking-wide select-none whitespace-nowrap">days</label>
                                </div>
                                @error('days')
                                    <div class="mt-1 text-xs text-red-500 tracking-wide">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-6 w-80" x-show="repeat">
                                <label for="end_date" class="block mb-1 font-medium text-text-200 tracking-wide">End date</label>
                                <input
                                    type="date"
                                    name="end_date"
                                    value="{{ old('end_date', request('end_date') ? request('end_date') : now()->addDays(7)->toDateString()) }}"
                                    id="end_date"
                                    min="{{ now()->addDays(1)->toDateString() }}"
                                    x-on:change="loading = true"
                                    x-on:blur="$refs.settings.submit()"
                                    @class([
                                        'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-40 focus:ring-2 bg-bg-200',
                                        'ring-slate-300' => !$errors->has('end_date'),
                                        'ring-red-500' => $errors->has('end_date')
                                    ])
                                />
                                @error('end_date')
                                    <div class="mt-1 text-xs text-red-500 tracking-wide">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <x-title>Available hours</x-title>

            <div class="flex flex-col relative">
                <x-loader :x-show="'loading'" />

                <form action="{{ route('admin.movies.schedules.store', ['movie' => $movie]) }}" method="POST" x-ref="createSchedule">
                    @csrf
                    <input type="hidden" name="cinema_hall" value="{{ old('cinema_hall', request('cinema_hall') ? request('cinema_hall') : $cinemaHalls->first()->id) }}" />
                    <input type="hidden" name="movie_type" value="{{ old('movie_type', request('movie_type') ? request('movie_type') : $movieTypes->first()->id) }}" />
                    <input type="hidden" name="price" value="{{ old('price', request('price') ? request('price') : 5) }}" />
                    <input type="hidden" name="start_date" value="{{ old('start_date', request('start_date') ? request('start_date') : now()->toDateString()) }}" />
                    <input type="hidden" name="repeat" value="{{ old('repeat') === 'on' || request('repeat') === 'on' ? 'true' : 'false' }}" />
                    <input type="hidden" name="days" value="{{ old('days', request('days') ? request('days') : 7) }}" />
                    <input type="hidden" name="end_date" value="{{ old('end_date', request('end_date') ? request('end_date') : now()->addDays(7)->toDateString()) }}" />
                    <div class="py-4 flex flex-wrap gap-4 justify-center">
                        @forelse ($availableHours as $hour)
                            <div class="flex items-center justify-between">
                                <input
                                    type="radio"
                                    name="hour"
                                    value="{{ $hour }}" id="{{ $hour }}"
                                    x-on:change="sending = true; $refs.createSchedule.submit()"
                                    class="hidden"
                                />
                                <label
                                    for="{{ $hour }}"
                                    class="flex items-center bg-bg-300 rounded-md hover:opacity-80 cursor-pointer"
                                >
                                    <span class="w-16 text-text-200 flex justify-center">{{ $hour }}</span>
                                    <div class="p-1.5 bg-bg-200 rounded-md">
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
            <x-loading :x-show="'sending'">The schedule addition is in progress</x-loading>
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
