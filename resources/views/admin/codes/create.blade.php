<x-layout>
    <x-main-with-box>
        <x-breadcrumbs class="my-4"
            :links="['Admin Panel' => route('admin.index'), 'Codes Management' => route('admin.codes.index'), 'Generate new code' => '#']" />

        <x-title>Generate new code</x-title>
        <div x-data="{ loading: false }" class="flex justify-center">
            <form action="{{ route('admin.codes.store') }}" method="POST">
                @csrf
                <div class="mb-6 w-80">
                    <label for="value" class="block mb-1 font-medium text-text-200 tracking-wide">Value</label>
                    <input
                        type="number"
                        name="value"
                        value="5"
                        id="value"
                        min="5"
                        max="1000"
                        step="0.01"
                        onblur="formatNumber(this)"
                        @class([
                            'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-40 focus:ring-2 bg-bg-200',
                            'ring-slate-300' => !$errors->has('value'),
                            'ring-red-500' => $errors->has('value')
                        ])
                    />
                    @error('value')
                        <div class="mt-1 text-xs text-red-500 tracking-wide">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="w-full flex justify-center">
                    <button
                        x-on:click="loading = true"
                        class="px-5 py-2 rounded-md bg-accent-100 hover:bg-accent-100/80 text-gray-950 font-bold tracking-wider"
                    >Generate new code</button>
                </div>
            </form>
            <x-loading :x-show="'loading'">Account top-up is being processed</x-loading>
        </div>
    </x-main-with-box>
    <script>
        function formatNumber(input) {
            if(input.value > 1000) input.value = 1000;
            if(input.value < 5) input.value = 5;
            input.value = parseFloat(input.value).toFixed(2);
        }
    </script>
</x-layout>
