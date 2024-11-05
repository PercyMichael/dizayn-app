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

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4 md:space-y-6">
                @csrf

                <!-- Hidden fields for email and token -->
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request()->email }}">

                <div>
                    <x-bladewind.input label="New Password" prefix="key" prefix_is_icon="true" type="password"
                        name="password" placeholder="******" required viewable />
                </div>

                <div>
                    <x-bladewind.input label="Confirm Password" prefix="key" prefix_is_icon="true" type="password"
                        name="password_confirmation" placeholder="******" required viewable />
                </div>

                <x-bladewind.button color="green" can_submit="true">Reset Password</x-bladewind.button>
            </form>
        </x-bladewind::card>
    </div>
</x-layout>