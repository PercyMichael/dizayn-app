<x-layout>
    <div class="flex flex-col max-w-screen-sm mx-auto justify-center items-center h-screen">
        <img class="py-4 w-20" src="{{ asset('Dizayn-Logo.png') }}
" alt="logo">
        <x-bladewind::card class="w-4/5 px-10">
            @if (session('status'))
            <x-bladewind::alert type="success" show_close_icon="true" class="text-sm">
                {{ session('status') }}
            </x-bladewind::alert>
            @endif


            @if ($errors->any())
            <x-bladewind::alert type="error" show_close_icon="true" class="text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-bladewind::alert>
            @endif

            <form action="/signin" method="post" class="space-y-4 md:space-y-6">

                @csrf
                <div>
                    <x-bladewind.input label="Your email" prefix="envelope" prefix_is_icon="true" type="email"
                        name="email" placeholder="name@company.com" required />
                </div>


                <div>
                    <x-bladewind.input label="Your password" prefix="key" prefix_is_icon="true" type="password"
                        name="password" placeholder="******" required viewable />
                    <p class="text-right">
                        <a href="{{ route('password.request') }}" class="text-green-500">Forgot Password?</a>
                    </p>
                </div>


                <x-bladewind.button color="green" can_submit="true">Sign in</x-bladewind.button>



            </form>


            <p class="text-center py-8">Don't have an account? <a href="/signup" class="text-green-500">Sign up</a> </p>

        </x-bladewind::card>
    </div>
</x-layout>