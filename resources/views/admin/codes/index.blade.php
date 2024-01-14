<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Admin Panel' => route('admin.index'), 'Codes Management' => '#']" />

        <x-title>Codes Management</x-title>
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.codes.create') }}" class="flex items-center bg-bg-200 rounded-md hover:opacity-80">
                <div class="p-1 bg-accent-100 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <span class="px-2 text-text-200">Generate new code</span>
            </a>
        </div>
        <div class="mx-4 flex flex-col gap-4">
            @forelse ($codes as $code)
                <div class="flex items-center justify-between flex-wrap" x-data="{ visible: false }">
                    <div class="flex items-center bg-bg-300 rounded-md order-1">
                        <div class="p-1 bg-bg-200 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="{{ $code->active === 1 ? 'currentColor' : 'red' }}" class="w-4 sm:w-6 h-4 sm:h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div class="w-20 px-2 tracking-wider flex justify-end font-semibold text-sm sm:text-base">
                            {{ number_format($code->value, 2) }}
                        </div>
                    </div>
                    <div class="w-full sm:w-auto mt-4 sm:mt-0 flex justify-center sm:block order-3 sm:order-2" x-show="visible">
                        <div class="flex gap-4 items-center bg-bg-300 rounded-md ">
                            <div class="p-1 bg-bg-200 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 sm:w-6 h-4 sm:h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                            <span>
                                {{ $code->code }}
                            </span>
                            <div class="p-1 bg-bg-200 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 sm:w-6 h-4 sm:h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <button
                        class="px-4 py-0.5 bg-bg-300 rounded-md hover:opacity-80 tracking-wider text-sm sm:text-base order-2 sm:order-3"
                        x-on:click="visible = !visible"
                        x-text="visible ? 'Hide code' : 'Show code'">
                    </button>
                </div>
                <hr class="border-bg-300" />
            @empty
                <div class="py-8 flex justify-center tracking-wider text-text-200">
                    No codes found
                </div>
            @endforelse
        </div>
    </x-main-with-box>
</x-layout>
