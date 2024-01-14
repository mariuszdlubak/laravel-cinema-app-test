<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Tickets' => '#']" />

        <x-title>Your tickets</x-title>
        <div class="flex flex-col">
            @forelse ($tickets as $ticket)
                <x-ticket :$ticket />
            @empty
                <div class="py-8 text-center tracking-wider text-text-200">
                    <p>You don't have any tickets. Purchase a ticket <a href="{{ route('movies.index') }}" class="text-accent-100 hover:underline">here.</a></p>
                </div>
            @endforelse
        </div>
    </x-main-with-box>
</x-layout>
