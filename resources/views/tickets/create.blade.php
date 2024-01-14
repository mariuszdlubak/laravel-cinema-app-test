<x-layout>
    <x-main>
        <x-main-box>
            <x-breadcrumbs class="my-4"
                :links="['Movies' => route('movies.index'), $movieSchedule->movieType->movie->title => route('movies.show', $movieSchedule->movieType->movie), 'Buy ticket' => '#']" />

            <x-title>Buy a ticket for {{ $movieSchedule->movieType->movie->title }}</x-title>
            <div x-data="{ isSelected: [], selectedItems: [], loading: false }" class="pt-10 flex flex-col gap-1 items-center">
                <form action="{{ route('ticket.store', ['movieSchedule' => $movieSchedule]) }}" method="POST" class="flex flex-col items-center">
                    @csrf
                    <div class="w-[80%] mb-8 border-t-4 border-gray-950 text-center text-gray-950 font-semibold tracking-widest">SCREEN</div>
                    @foreach ($seats as $r => $rows)
                        <div class="pt-2 pb-1 flex items-center gap-1 border-b border-b-text-200">
                            <span class="pl-2 sm:pl-4 pr-4 sm:pr-8">{{ $r + 1 }}</span>
                            @foreach ($rows as $s => $seat)
                                @if ($seat->blocked === 1)
                                    <div class="w-6 md:w-10 h-6 md:h-10"></div>
                                @elseif (in_array($seat->id, $occupiedSeats))
                                    <div class="w-6 md:w-10 h-6 md:h-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="#292e3b" class="rotate-180">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-6 md:w-10 h-6 md:h-10">
                                        <input type="checkbox" x-model="isSelected[{{ $r + 1 }}_{{ $s }}]" id="{{ $seat->id }}" name="{{ $seat->id }}" class="hidden">
                                        <label
                                            for="{{ $seat->id }}"
                                            @click="isSelected[{{ $r + 1 }}_{{ $s }}] ? selectedItems.pop(1) : selectedItems.push(1)"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24"
                                                stroke-width="1"
                                                :stroke="isSelected[{{ $r + 1 }}_{{ $s }}] ? 'green' : '#e0e0e0'"
                                                class="rotate-180 cursor-pointer"
                                            >
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                            </svg>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                            <span class="pl-4 sm:pl-8 pr-2 sm:pr-4">{{ $r + 1 }}</span>
                        </div>
                    @endforeach
                    <div class="my-4 self-start flex space-x-8 text-text-200 text-sm">
                        <div class="flex items-center space-x-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24"
                                stroke-width="1"
                                stroke="#e0e0e0"
                                class="w-6 md:w-8 h-6 md:h-8 rotate-180"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                            <span>Available</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1"
                                stroke="#292e3b"
                                class="w-6 md:w-8 h-6 md:h-8 rotate-180"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                            <span>Occupied</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24"
                                stroke-width="1"
                                stroke="green"
                                class="w-6 md:w-8 h-6 md:h-8 rotate-180"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                            <span>Selected</span>
                        </div>
                    </div>
                    <div class="my-4 w-full flex justify-between">
                        <a href="{{ route('movies.show', ['movie' => $movieSchedule->movieType->movie]) }}" class="px-2 sm:px-4 py-1 sm:py-2 rounded-md text-sm sm:text-base bg-bg-200 hover:opacity-90 tracking-wider text-gray-950 flex items-center">
                            Cancel
                        </a>
                        <button
                            x-show="selectedItems.length > 0"
                            x-on:click="loading = true"
                            class="rounded-md text-sm sm:text-base bg-accent-200 hover:opacity-90 tracking-wider text-gray-950 flex items-center"
                        >
                            <span
                                x-text="`Buy ${selectedItems.length} ${selectedItems.length === 1 ? 'ticket' : 'tickets'}`"
                                class="px-2 sm:px-4"
                            ></span>
                            <div
                                x-text="`$${(selectedItems.length * {{ $movieSchedule->price }}).toFixed(2)}`"
                                class="px-2 py-1 sm:py-2 rounded-md bg-accent-100 font-medium text-text-100"
                            ></div>
                        </button>
                    </div>
                </form>
                <x-loading :x-show="'loading'">Your purchase is being processed</x-loading>
            </div>
        </x-main-box>
    </x-main>
</x-layout>
