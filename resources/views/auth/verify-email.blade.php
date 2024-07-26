<x-layout>
    <x-header />
    <div class="flex flex-col max-w-screen-sm mx-auto justify-center items-center h-screen">

        <x-bladewind::card class="w-4/5 px-16">
            <div class="flex flex-col justify-center items-center gap-y-6 max-w-screen-lg mx-auto md:px-0 px-4">
                <div class="bg-green-200 p-5 rounded-full text-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                        <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                    </svg>
                </div>
                <div class="text-center">
                    @if (session('message') == 'Verification link sent!')
                    <h1 class="text-3xl font-black text-gray-700">A new verification link has been sent to</h1>
                    <p class="text-lg font-bold">{{Auth::user()->email}}</p>
                    @else
                    <h1 class="text-3xl font-black text-gray-700">Verify Your Email Address</h1>
                    <p class="text-center text-gray-600">Before proceeding, please check your email for a verification link.
                        If you did not receive the email to
                    </p>
                    <p class="text-lg font-bold">{{Auth::user()->email}}</p>
                </div>
                <!-- bg-[#2422DE] -->
                <form method="POST" action="/email/verification-notification">
                    @csrf
                    <x-bladewind.button color="green" can_submit="true">Click here to request another</x-bladewind.button>.
                </form>
                @endif
            </div>

        </x-bladewind::card>
    </div>
</x-layout>