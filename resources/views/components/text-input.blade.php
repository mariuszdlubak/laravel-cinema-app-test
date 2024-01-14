<div class="relative">
    @if('textarea' != $type)
        <input
            x-ref="input-{{ $name }}"
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            id="{{ $name }}"
            @class([
                'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-40 focus:ring-2 bg-bg-200',
                'pr-8' => $formRef,
                'ring-slate-300' => !$errors->has($name),
                'ring-red-500' => $errors->has($name)
            ])
        />
    @else
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            @class([
                'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-40 focus:ring-2 bg-bg-200',
                'pr-8' => $formRef,
                'ring-slate-300' => !$errors->has($name),
                'ring-red-500' => $errors->has($name)
            ])
        >{{ old($name, $value) }}</textarea>
    @endif

    @error($name)
        <div class="mt-1 text-xs text-red-500 tracking-wide">
            {{ $message }}
        </div>
    @enderror

    @if(session('login_error'))
        <div class="mt-1 text-xs text-red-500 tracking-wide">
            {{ session('login_error') }}
        </div>
    @endif
</div>
