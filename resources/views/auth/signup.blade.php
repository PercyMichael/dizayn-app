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

            <form action="/signup" method="post" class="space-y-4 md:space-y-6">

                @csrf
                <div>
                    <x-bladewind.input label="Your name" prefix="user" prefix_is_icon="true" type="text" name="name" placeholder="John Doe" value="{{ old('name') }}" required />
                </div>

                <div>
                    <x-bladewind.input label="Your email" prefix="envelope" prefix_is_icon="true" type="email" name="email" placeholder="name@company.com" value="{{ old('email') }}" required />
                </div>

                <div>
                    <x-bladewind.input label="Your password" prefix="key" prefix_is_icon="true" type="password" name="password" placeholder="******" required viewable />
                </div>

                <div>
                    <x-bladewind.input label="Confirm Your password" prefix="key" prefix_is_icon="true" type="password" name="password_confirmation" placeholder="******" required viewable />
                </div>

                <div class="flex justify-end">
                    <x-bladewind.button color="green" can_submit="true">Sign up</x-bladewind.button>
                </div>
            </form>

            <p class="text-center py-8">Already have an account? <a href="/signin" class="text-green-500">Sign in</a> </p>

        </x-bladewind::card>
    </div>
</x-layout>