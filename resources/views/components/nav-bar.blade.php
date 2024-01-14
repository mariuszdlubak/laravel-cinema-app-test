<div class="w-full fixed z-20 bg-gray-950 flex flex-col shadow-lg items-center">
    <div class="w-full max-w-6xl h-20 px-4 flex items-center justify-between">
        <a href="{{ route('home.index') }}" class="flex items-center space-x-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 sm:w-12 h-8 sm:h-12 text-accent-100">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0118 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0118 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 016 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M19.125 12h1.5m0 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h1.5m14.25 0h1.5" />
            </svg>
            <div class="hidden sm:block text-accent-100 font-extrabold tracking-widest text-xl md:text-3xl">STARLIGHT</div>
        </a>
        <div>
            <ul class="flex items-center space-x-4">
                @auth
                    <li>
                        {{ auth()->user()->name }}
                    </li>
                    <li>
                        <a href="{{ route('balance.create') }}" class="flex items-center rounded-md bg-bg-100 text-sm sm:text-base text-text-200 hover:opacity-80">
                            <span class="px-4 hidden sm:block">
                                Balance
                            </span>
                            <span class="px-2 py-1 rounded-md bg-accent-100 text-gray-950 font-semibold">
                                ${{ number_format(auth()->user()->balance, 2) }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('auth.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="px-2 py-1 rounded-md text-sm sm:text-base bg-bg-300 hover:opacity-90 tracking-wider text-gray-950">Logout</button>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="{{ route('auth.create') }}" class="px-2 py-1 rounded-md text-sm sm:text-base bg-accent-100 hover:opacity-90 tracking-wider text-gray-950">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
    <nav class="w-full h-8 px-4 bg-bg-200 flex items-center justify-center">
        <ul class="w-full max-w-6xl text-gray-950 flex justify-between font-semibold tracking-wider text-sm md:text-base">
            @auth
                <li class="w-1/4 text-center">
                    <a href="{{ route('home.index') }}">
                        HOME
                    </a>
                </li>
                <li class="w-1/4 text-center">
                    <a href="{{ route('movies.index') }}">
                        MOVIES
                    </a>
                </li>
                <li class="w-1/4 text-center">
                    <a href="{{ route('popular.index') }}">
                        POPULAR
                    </a>
                </li>
                <li class="w-1/4 text-center">
                    <a href="{{ route('tickets.index') }}">
                        TICKETS
                    </a>
                </li>
            @else
                <li class="w-1/3 text-center">
                    <a href="/">
                        HOME
                    </a>
                </li>
                <li class="w-1/3 text-center">
                    <a href="{{ route('movies.index') }}">
                        MOVIES
                    </a>
                </li>
                <li class="w-1/4 text-center">
                    <a href="{{ route('popular.index') }}">
                        POPULAR
                    </a>
                </li>
            @endauth
        </ul>
        @auth
            @if(auth()->user()->login === 'admin')
                <a
                    href="{{ route('admin.index') }}"
                    class="p-3 fixed bottom-8 right-8 bg-accent-100 hover:bg-accent-100/80 rounded-full shadow-md"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#030712" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                    </svg>
                </a>
            @endif
        @endauth
    </nav>
</div>
