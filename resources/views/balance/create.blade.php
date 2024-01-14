<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Top up your account' => '#']" />

        <x-title>Top up your account</x-title>
        <div x-data="{ loading: false }" class="flex justify-center">
            <form action="{{ route('balance.store') }}" method="POST">
                @csrf
                <div class="mb-6 w-80">
                    <label for="code" class="block mb-1 font-medium text-text-200 tracking-wide">Code</label>
                    <x-text-input name="code" />
                </div>
                <div class="w-full flex justify-center">
                    <button
                        x-on:click="loading = true"
                        class="px-5 py-2 rounded-md bg-accent-100 hover:bg-accent-100/80 text-gray-950 font-bold tracking-wider"
                    >Redeem code</button>
                </div>
            </form>
            <x-loading :x-show="'loading'">Account top-up is being processed</x-loading>
        </div>
    </x-main-with-box>
</x-layout>
