<x-layout>
    <x-main-with-box>
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <h2 class="my-8 text-center text-3xl font-semibold text-text-200 tracking-widest">Login</h2>
                <form action="{{ route('auth.store') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="login" class="block mb-1 font-medium text-text-200 tracking-widest">Login</label>
                        <x-text-input name="login" />
                    </div>
                    <div class="mb-2">
                        <label for="password" class="block mb-1 font-medium text-text-200 tracking-widest">Password</label>
                        <x-text-input name="password" type="password" />
                    </div>
                    <div class="mb-6 flex justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="accent-accent-100 cursor-pointer" />
                            <label for="remember" class="pl-2 text-accent-200 text-sm tracking-widest select-none cursor-pointer">Remember me</label>
                        </div>
                        <a
                            href="{{ route('auth.forgotpassword') }}"
                            class="text-accent-200 tracking-widest text-sm hover:underline"
                        >
                            Forgot Password
                        </a>
                    </div>
                    <div class="w-full flex justify-center">
                        <button class="px-10 py-2 rounded-md bg-accent-100 hover:bg-accent-100/80 text-gray-950 font-bold tracking-wider">Login</button>
                    </div>
                    <div class="mt-6 flex justify-center space-x-2 tracking-wider text-sm">
                        <p>
                            You don't have an account?
                            <a
                                href="{{ route('auth.register') }}"
                                class="text-accent-100 tracking-widest hover:underline"
                            >
                                Sign up
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </x-main-with-box>
</x-layout>
