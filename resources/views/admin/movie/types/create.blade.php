<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Admin Panel' => route('admin.index'), 'Movies Management' => route('admin.movies.index'), $movie->title => route('admin.movies.edit', $movie), 'Schedules' => route('admin.movies.schedules.index', $movie), 'Add new type' => '#']" />

        <x-title>Add new type for {{ $movie->title }}</x-title>
        <div x-data="{ loading: false }" class="flex justify-center">
            <form action="{{ route('admin.movies.types.store', ['movie' => $movie]) }}" method="POST">
                @csrf
                <div class="mb-4 w-80">
                    <label for="type" class="block mb-1 font-medium text-text-200 tracking-wide">Type</label>
                    <x-text-input name="type" />
                </div>
                <div class="mb-6 w-80">
                    <label for="language" class="block mb-1 font-medium text-text-200 tracking-wide">Language</label>
                    <x-text-input name="language" />
                </div>
                <div class="w-full flex justify-center">
                    <button
                        x-on:click="loading = true"
                        class="px-5 py-2 rounded-md bg-accent-100 hover:bg-accent-100/80 text-gray-950 font-bold tracking-wider"
                    >Add type</button>
                </div>
            </form>
            <x-loading :x-show="'loading'">Adding a new type is in progress</x-loading>
        </div>
    </x-main-with-box>
</x-layout>
