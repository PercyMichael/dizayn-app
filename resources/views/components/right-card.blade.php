<x-bladewind::card>
    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded border border-blue-400">
        @php echo date('F Y'); @endphp
    </span>

    <ul class="max-w-md divide-y divide-gray-200">
        <div class="flex-1 min-w-0 py-3">
            <p id="monthAndYear" class="text-lg font-bold text-gray-900 truncate py-3">
                Fashionably Late Club <span class="motion-safe:animate-ping">🕒</span>
            </p>

            <p class="text-sm text-gray-500">
                🕺💃 See who's making a habit of being fashionably late and how many times they've done it!
            </p>

        </div>

        @php
        // Filter users who have a check-in that is considered late this month
        $lateUsers = $users->filter(function ($user) {
        return $user->checkins->contains(function ($checkin) {
        return checkinStatus($checkin->created_at->subMinutes(5)) === 'late';
        });
        });
        @endphp

        @foreach ($lateUsers as $user)
        <li class="py-3 sm:py-4">
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $user->name }}
                    </p>

                    @php
                    // Filter late check-ins for the user
                    $lateCheckins = $user->checkins->filter(function ($checkin) {
                    return checkinStatus($checkin->created_at) === 'late';
                    });
                    @endphp

                    @foreach ($lateCheckins as $checkin)
                    <p class="text-sm text-gray-500 truncate py-1">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">
                            {{ $checkin->created_at->subMinutes(5)->format('D, jS h:ia') }}
                        </span>
                    </p>
                    @endforeach

                </div>
                <div class="flex flex-col items-center text-base font-semibold">
                    <div class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full">
                        {{ $lateCheckins->count() }}
                    </div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    </div>

</x-bladewind::card>