<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Admin Panel' => route('admin.index'), 'Movies Management' => route('admin.movies.index'), $movie->title => '#', 'Edit movie' => '#']" />

        <form
            x-data="{ loading: false }"
            action="{{ route('admin.movies.update', $movie) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')
            <div class="w-full h-56 sm:h-96" x-data="{ imagePreview: null }">
                <label class="cursor-pointer">
                    <img
                        :src="imagePreview"
                        alt="Banner"
                        @class([
                            'w-full h-full rounded-md object-cover ring-1',
                            'ring-gray-300' => !$errors->has('banner'),
                            'ring-red-500' => $errors->has('banner')
                        ])
                        :class="imagePreview ? '' : 'hidden'"
                    />
                    <img
                        src="{{ asset('storage/' . $movie->baner_path) }}"
                        alt="Banner"
                        @class([
                            'w-full h-full rounded-md object-cover ring-1',
                            'ring-gray-300' => !$errors->has('banner'),
                            'ring-red-500' => $errors->has('banner')
                        ])
                        :class="imagePreview ? 'hidden' : ''"
                    />
                    <input type="file" name="banner" class="hidden" accept="image/*" @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                </label>
            </div>
            @error('banner')
                <div class="my-2 text-xs text-center text-red-500 tracking-wide">
                    {{ $message }}
                </div>
            @enderror
            <div>
                <div class="my-4 pb-2 border-b-2 border-bg-300 tracking-widest">
                    <input
                        type="text"
                        name="title"
                        placeholder="Title"
                        value="{{ old('title', $movie->title) }}"
                        @class([
                            'w-full px-2 text-xl font-semibold bg-transparent ring-1 rounded-md',
                            'ring-gray-300' => !$errors->has('title'),
                            'ring-red-500' => $errors->has('title')
                        ])
                    />
                    @error('title')
                        <div class="my-2 text-xs text-center text-red-500 tracking-wide">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                    <div>
                        <div class="w-48 h-72"  x-data="{ imagePreview: null }">
                            <label class="cursor-pointer">
                                <img
                                    :src="imagePreview"
                                    alt="Icon"
                                    @class([
                                        'w-full h-full rounded-md object-cover ring-1',
                                        'ring-gray-300' => !$errors->has('icon'),
                                        'ring-red-500' => $errors->has('icon')
                                    ])
                                    :class="imagePreview ? '' : 'hidden'"
                                />
                                <img
                                    src="{{ asset('storage/' . $movie->icon_path) }}"
                                    alt="Icon"
                                    @class([
                                        'w-full h-full rounded-md object-cover ring-1',
                                        'ring-gray-300' => !$errors->has('icon'),
                                        'ring-red-500' => $errors->has('icon')
                                    ])
                                    :class="imagePreview ? 'hidden' : ''"
                                />
                                <input type="file" name="icon" class="hidden" accept="image/*" @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                            </label>
                        </div>
                        @error('icon')
                            <div class="my-2 text-xs text-center text-red-500 tracking-wide">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="w-full sm:w-80 sm:grow text-text-200">
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
                        <div>
                            <textarea
                                type="text"
                                name="description"
                                placeholder="Description"
                                @class([
                                    'w-full h-56 px-2 bg-transparent ring-1 rounded-md',
                                    'ring-gray-300' => !$errors->has('description'),
                                    'ring-red-500' => $errors->has('description')
                                ])
                            >{{ old('description', $movie->description) }}</textarea>
                            @error('description')
                                <div class="my-2 text-xs text-center text-red-500 tracking-wide">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="my-4 pb-2 border-b-2 border-bg-300 tracking-widest">
                    <h2 class="f text-xl font-semibold">Additional information</h2>
                </div>
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
                        <div class="w-full">
                            <textarea
                                type="text"
                                name="fun_fact"
                                placeholder="Fascinating fact"
                                @class([
                                    'w-full h-56 px-2 bg-transparent ring-1 rounded-md',
                                    'ring-gray-300' => !$errors->has('fun_fact'),
                                    'ring-red-500' => $errors->has('fun_fact')
                                ])
                            >{{ old('fun_fact', $movie->fun_fact) }}</textarea>
                            @error('fun_fact')
                                <div class="my-2 text-xs text-center text-red-500 tracking-wide">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <table class="md:w-40 md:grow text-sm tracking-wide text-text-200">
                        <tr class="bg-bg-200">
                            <td class="px-2 py-1 font-semibold">Release date</td>
                            <td class="px-2 py-1">
                                <input
                                    type="date"
                                    name="release_date"
                                    placeholder="Release date"
                                    value="{{ old('release_date', $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('Y-m-d') : '') }}"
                                    @class([
                                        'w-full px-2 bg-transparent ring-1 rounded-md',
                                        'ring-gray-300' => !$errors->has('release_date'),
                                        'ring-red-500' => $errors->has('release_date')
                                    ])
                                />
                            </td>
                        </tr>
                        @error('release_date')
                            <tr class="bg-bg-200">
                                <td colspan="2" class="text-xs text-center text-red-500 tracking-wide">{{ $message }}</td>
                            </tr>
                        @enderror
                        <tr class="bg-bg-300">
                            <td class="px-2 py-1 font-semibold">Duration</td>
                            <td class="px-2 py-1">
                                <input
                                    type="number"
                                    name="duration"
                                    placeholder="Duration"
                                    value="{{ old('duration', $movie->duration) }}"
                                    @class([
                                        'w-full px-2 bg-transparent ring-1 rounded-md',
                                        'ring-gray-300' => !$errors->has('duration'),
                                        'ring-red-500' => $errors->has('duration')
                                    ])
                                />
                            </td>
                        </tr>
                        @error('duration')
                            <tr class="bg-bg-300">
                                <td colspan="2" class="text-xs text-center text-red-500 tracking-wide">{{ $message }}</td>
                            </tr>
                        @enderror
                        <tr class="bg-bg-200">
                            <td class="px-2 py-1 font-semibold">Genre</td>
                            <td class="px-2 py-1">
                                <input
                                    type="text"
                                    name="genre"
                                    placeholder="Genre"
                                    value="{{ old('genre', $movie->genre) }}"
                                    @class([
                                        'w-full px-2 bg-transparent ring-1 rounded-md',
                                        'ring-gray-300' => !$errors->has('genre'),
                                        'ring-red-500' => $errors->has('genre')
                                    ])
                                />
                            </td>
                        </tr>
                        @error('genre')
                            <tr class="bg-bg-200">
                                <td colspan="2" class="text-xs text-center text-red-500 tracking-wide">{{ $message }}</td>
                            </tr>
                        @enderror
                        <tr class="bg-bg-300">
                            <td class="px-2 py-1 font-semibold">Cast</td>
                            <td class="px-2 py-1">
                                <input
                                    type="text"
                                    name="cast"
                                    placeholder="Cast"
                                    value="{{ old('cast', $movie->cast) }}"
                                    @class([
                                        'w-full px-2 bg-transparent ring-1 rounded-md',
                                        'ring-gray-300' => !$errors->has('cast'),
                                        'ring-red-500' => $errors->has('cast')
                                    ])
                                />
                            </td>
                        </tr>
                        @error('cast')
                            <tr class="bg-bg-300">
                                <td colspan="2" class="text-xs text-center text-red-500 tracking-wide">{{ $message }}</td>
                            </tr>
                        @enderror
                        <tr class="bg-bg-200">
                            <td class="px-2 py-1 font-semibold">Director</td>
                            <td class="px-2 py-1">
                                <input
                                    type="text"
                                    name="director"
                                    placeholder="Director"
                                    value="{{ old('director', $movie->director) }}"
                                    @class([
                                        'w-full px-2 bg-transparent ring-1 rounded-md',
                                        'ring-gray-300' => !$errors->has('director'),
                                        'ring-red-500' => $errors->has('director')
                                    ])
                                />
                            </td>
                        </tr>
                        @error('director')
                            <tr class="bg-bg-200">
                                <td colspan="2" class="text-xs text-center text-red-500 tracking-wide">{{ $message }}</td>
                            </tr>
                        @enderror
                        <tr class="bg-bg-300">
                            <td class="px-2 py-1 font-semibold">Production</td>
                            <td class="px-2 py-1">
                                <input
                                    type="text"
                                    name="production"
                                    placeholder="Production"
                                    value="{{ old('production', $movie->production) }}"
                                    @class([
                                        'w-full px-2 bg-transparent ring-1 rounded-md',
                                        'ring-gray-300' => !$errors->has('production'),
                                        'ring-red-500' => $errors->has('production')
                                    ])
                                />
                            </td>
                        </tr>
                        @error('production')
                            <tr class="bg-bg-300">
                                <td colspan="2" class="text-xs text-center text-red-500 tracking-wide">{{ $message }}</td>
                            </tr>
                        @enderror
                        <tr class="bg-bg-200">
                            <td class="px-2 py-1 font-semibold">Original language</td>
                            <td class="px-2 py-1">
                                <input
                                    type="text"
                                    name="original_language"
                                    placeholder="Original language"
                                    value="{{ old('original_language', $movie->original_language) }}"
                                    @class([
                                        'w-full px-2 bg-transparent ring-1 rounded-md',
                                        'ring-gray-300' => !$errors->has('original_language'),
                                        'ring-red-500' => $errors->has('original_language')
                                    ])
                                />
                            </td>
                        </tr>
                        @error('original_language')
                            <tr class="bg-bg-200">
                                <td colspan="2" class="text-xs text-center text-red-500 tracking-wide">{{ $message }}</td>
                            </tr>
                        @enderror
                        <tr class="bg-bg-300">
                            <td class="px-2 py-1 font-semibold">Age restrictions</td>
                            <td class="px-2 py-1">
                                <input
                                    type="number"
                                    name="age_restrictions"
                                    placeholder="Age restrictions"
                                    value="{{ old('age_restrictions', $movie->age_restrictions) }}"
                                    @class([
                                        'w-full px-2 bg-transparent ring-1 rounded-md',
                                        'ring-gray-300' => !$errors->has('age_restrictions'),
                                        'ring-red-500' => $errors->has('age_restrictions')
                                    ])
                                />
                            </td>
                        </tr>
                        @error('age_restrictions')
                            <tr class="bg-bg-300">
                                <td colspan="2" class="text-xs text-center text-red-500 tracking-wide">{{ $message }}</td>
                            </tr>
                        @enderror
                    </table>
                </div>

                <div class="my-4 pb-2 border-b-2 border-bg-300 tracking-widest">
                    <h2 class="f text-xl font-semibold">Trailer</h2>
                </div>
                <div class="w-full flex flex-col justify-center">
                    <textarea
                        type="text"
                        name="trailer"
                        placeholder="Trailer path"
                        @class([
                            'w-full aspect-video rounded-lg overflow-hidden px-2 bg-transparent ring-1 rounded-md',
                            'ring-gray-300' => !$errors->has('trailer'),
                            'ring-red-500' => $errors->has('trailer')
                        ])
                    >{{ old('trailer', $trailer) }}</textarea>
                    @error('trailer')
                        <div class="my-2 text-xs text-center text-red-500 tracking-wide">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <a href="{{ route('admin.movies.index') }}" class="fixed top-32 left-10 z-10 px-4 py-1 rounded-md shadow-md bg-bg-300 text-gray-950 hover:opacity-80">Cancel</a>
            <button
                x-on:click="loading = true"
                class="fixed top-32 right-10 z-10 px-4 py-1 rounded-md shadow-md bg-accent-100 text-gray-950 hover:opacity-80"
            >Save</button>
            <x-loading :x-show="'loading'">Updating the movie is in progress</x-loading>
        </form>
    </x-main-with-box>
</x-layout>
