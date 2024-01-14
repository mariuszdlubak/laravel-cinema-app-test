<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Admin Panel' => route('admin.index'), 'Cinema Halls Management' => '#']" />

        <x-title>Cinema Halls Management</x-title>
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.cinemahalls.create') }}" class="flex items-center bg-bg-200 rounded-md hover:opacity-80">
                <div class="p-1 bg-accent-100 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <span class="px-2 text-text-200">Add new hall</span>
            </a>
        </div>
        <div class="mx-4 flex flex-col gap-4">
            @forelse ($cinemaHalls as $hall)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 bg-bg-200 rounded-md text-lg font-bold flex items-center justify-center">
                            {{ $hall->name }}
                        </div>
                        <div class="flex gap-2">
                            <span class="font-semibold tracking-wider">Seats:</span>
                            <span>{{ $hall->seats_count }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.cinemahalls.edit', $hall) }}" class="px-4 py-0.5 bg-bg-300 rounded-md hover:opacity-80 tracking-wider">Edit</a>
                </div>
                <hr class="border-bg-300" />
            @empty
                <div class="py-8 flex justify-center tracking-wider text-text-200">
                    No cinema halls found
                </div>
            @endforelse
        </div>
    </x-main-with-box>
</x-layout>
