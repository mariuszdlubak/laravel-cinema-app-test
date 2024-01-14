<x-layout>
    <x-main>
        <x-main-box>
            <x-breadcrumbs class="my-4"
                :links="['Admin Panel' => route('admin.index'), 'Cinema Halls Management' => route('admin.cinemahalls.index'), 'New hall' => '#']" />

            <x-title>Cinema hall {{ $name }}</x-title>
            <div x-data="{ isSelected: [], loading: false }" class="pt-10 flex flex-col gap-1 items-center">
                <form action="{{ route('admin.cinemahalls.store') }}" method="POST" class="flex flex-col items-center">
                @csrf
                    <div class="w-[80%] mb-8 border-t-4 border-gray-950 text-center text-gray-950 font-semibold tracking-widest">SCREEN</div>
                    @foreach ($rows as $r => $row)
                        <div class="pt-2 pb-1 flex items-center gap-1 border-b border-b-text-200">
                            <span class="pl-2 sm:pl-4 pr-4 sm:pr-8">{{ $row }}</span>
                            @foreach ($seats as $s => $seat)
                                <div class="w-6 md:w-10 h-6 md:h-10">
                                    <input type="checkbox" x-model="isSelected[{{ $r + 1 }}_{{ $s }}]" id="{{ $row . $seat }}" name="{{ $row . $seat }}" class="hidden">
                                    <label
                                        for="{{ $row . $seat }}"
                                        @click="isSelected[{{ $r + 1 }}_{{ $s }}]"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24"
                                            stroke-width="1"
                                            :stroke="isSelected[{{ $r + 1 }}_{{ $s }}] ? '#292e3b' : '#e0e0e0'"
                                            class="rotate-180 cursor-pointer"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                        </svg>
                                    </label>
                                </div>
                            @endforeach
                            <span class="pl-4 sm:pl-8 pr-2 sm:pr-4">{{ $row }}</span>
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
                            <span>Blocked</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.cinemahalls.index') }}" class="fixed top-32 left-10 z-10 px-4 py-1 rounded-md shadow-md bg-bg-300 text-gray-950 hover:opacity-80">Cancel</a>
                    <button
                        x-on:click="loading = true"
                        class="fixed top-32 right-10 z-10 px-4 py-1 rounded-md shadow-md bg-accent-100 text-gray-950 hover:opacity-80"
                    >Add hall</button>
                </form>
                <x-loading :x-show="'loading'">Adding a cinema hall is in progress</x-loading>
            </div>
        </x-main-box>
    </x-main>
</x-layout>
