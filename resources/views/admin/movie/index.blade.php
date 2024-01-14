<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Admin Panel' => route('admin.index'), 'Movies Management' => '#']" />

        <x-title>Movies Management</x-title>
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.movies.create') }}" class="flex items-center bg-bg-200 rounded-md hover:opacity-80">
                <div class="p-1 bg-accent-100 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <span class="px-2 text-text-200">Add new</span>
            </a>
        </div>
        <div class="flex flex-col">
            @forelse ($movies as $movie)
                <x-admin-movie-card :$movie  />
            @empty
                <div class="py-8 flex justify-center tracking-wider text-text-200">
                    No movies found
                </div>
            @endforelse
            <div class="self-end">
                {{ $movies->links() }}
            </div>
        </div>
    </x-main-with-box>
</x-layout>
