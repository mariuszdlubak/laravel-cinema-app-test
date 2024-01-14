<div class="fixed top-0 left-0 z-50 w-full h-full bg-black/80 text-text-200 flex items-center justify-center" x-show="{{ $xShow }}">
    <div class="px-10 w-full md:max-w-xl flex flex-col items-center gap-4">
        <div class="py-10 flex gap-8">
            <div class='h-6 md:h-8 w-6 md:w-8 bg-accent-100 rounded-full animate-bounce [animation-delay:-0.3s]'></div>
            <div class='h-6 md:h-8 w-6 md:w-8 bg-accent-100 rounded-full animate-bounce [animation-delay:-0.15s]'></div>
            <div class='h-6 md:h-8 w-6 md:w-8 bg-accent-100 rounded-full animate-bounce'></div>
        </div>
        <h2 class="text-lg md:text-xl font-semibold text-center tracking-widest">{{ $slot }}</h2>
        <p class="text-center text-xs md:text-sm tracking-wider">Do not close this window until the operation is complete.</p>
    </div>
</div>
