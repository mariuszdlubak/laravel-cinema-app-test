<div {{ $attributes }}>
    <ul class="flex items-center flex-wrap space-x-2 text-slate-500 text-sm sm:text-base">
        <li class="whitespace-nowrap">
            <a href="/">Home</a>
        </li>

        @foreach ($links as $label => $link)
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                </svg>
            </li>
            <li class="whitespace-nowrap">
                <a href="{{ $link }}">
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
