<x-layout>
    <div class="flex flex-col max-w-screen-sm mx-auto justify-center items-center h-screen">
        <img class="py-4 w-20" src="{{ asset('Dizayn-Logo.png') }}" alt="logo">

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

            <form action="{{ route('password.email') }}" method="POST" class="space-y-4 md:space-y-4 flex flex-col">
                @csrf

                <div>
                    <x-bladewind.input label="Your email" prefix="envelope" prefix_is_icon="true" type="email"
                        name="email" placeholder="name@company.com" required />
                </div>

                <x-bladewind.button color="green" can_submit="true">Send Password Reset Link</x-bladewind.button>
            </form>

            <p class="text-center py-8">
                <a href="/signin" class="text-green-500">Back to Sign in</a>
            </p>
        </x-bladewind::card>
    </div>
</x-layout>