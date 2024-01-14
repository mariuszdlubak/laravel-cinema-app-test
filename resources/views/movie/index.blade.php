<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Movies' => '#']" />

        <div x-data="{ loading: false }">
            <div class="mb-4 bg-bg-200/10 rounded-md shadow-md">
                <form action="{{ route('movies.index') }}" method="GET" x-ref="filters">
                    <div class="p-4 bg-bg-200/20 rounded-md shadow-md">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-text-200">
                            <div class="flex flex-col">
                                <label for="search" class="p-1 text-sm font-medium tracking-widest">Search</label>
                                <input type="text" id="search" name="search" placeholder="Find movie" value="{{ request('search') }}" class="px-2 py-1 bg-bg-100 rounded-md outline-none ring-1 ring-gray-950 hover:ring-gray-900 tracking-wider" />
                            </div>
                            <div class="flex flex-col">
                                <span class="p-1 text-sm font-medium tracking-widest">Length</span>
                                <div class="flex space-x-4">
                                    <input type="number" name="length_from" placeholder="From" min="0" step="1" value="{{ request('length_from') }}" class="w-10 grow px-2 py-1 bg-bg-100 rounded-md outline-none ring-1 ring-gray-950 hover:ring-gray-900 tracking-wider" />
                                    <input type="number" name="length_to" placeholder="To" min="1" step="1" value="{{ request('length_to') }}" class="w-10 grow px-2 py-1 bg-bg-100 rounded-md outline-none ring-1 ring-gray-950 hover:ring-gray-900 tracking-wider" />
                                </div>
                            </div>
                            <div class="sm:col-span-2 flex flex-col items-center gap-1">
                                <span class="p-1 text-sm font-medium tracking-widest">Categories</span>
                                <div class="flex flex-wrap justify-center gap-y-2 gap-x-4 text-sm tracking-wider">
                                    @foreach (\App\Models\Movie::$category as $categories => $category)
                                        <div class="flex">
                                            <input
                                                type="checkbox"
                                                id="{{ $category }}"
                                                name="categories[]"
                                                value="{{ $category }}"
                                                class="accent-accent-100 cursor-pointer"
                                                @if(request()->has('categories') && in_array($category, request('categories'))) checked @endif
                                            />
                                            <label for="{{ $category }}" class="pl-2 cursor-pointer">{{ $category }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="sm:col-span-2 flex justify-center">
                                <button
                                    x-on:click="loading = true"
                                    class="px-8 py-1 bg-bg-200 text-gray-950 hover:bg-bg-200/70 rounded-md shadow-md font-semibold tracking-widest"
                                >
                                    Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-2 flex gap-3 sm:gap-4 sm:text-lg font-medium text-gray-950 tracking-wide overflow-hidden">
                        @foreach (\App\Models\Movie::days() as $day => $value)
                            <input
                                type="radio"
                                name="day"
                                value="{{ $value }}" id="{{ $day }}"
                                @if(request('day') === $value || (empty(request('day')) && $value === now()->format('Y-m-d')))) checked @endif
                                x-on:change="$refs.filters.submit(); loading = true"
                                class="hidden"
                            />
                            <label
                                for="{{ $day }}"
                                @class([
                                    'cursor-pointer hover:text-accent-200',
                                    'text-accent-100' => request('day') === $value || (empty(request('day')) && $value === now()->format('Y-m-d'))
                                ])
                            >
                                {{ ucfirst($day) }}
                            </label>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="flex flex-col relative">
                <x-loader :x-show="'loading'" />
                @forelse ($movies as $movie)
                    <x-movie-card :$movie :$tickets :$cinemaHalls  />
                @empty
                    <div class="py-8 flex justify-center tracking-wider text-text-200">
                        No movies found matching the criteria
                    </div>
                @endforelse
                <div class="self-end">
                    {{ $movies->links() }}
                </div>
            </div>
        </div>
    </x-main-with-box>
</x-layout>
