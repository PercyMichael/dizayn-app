<x-bladewind::card>
    @php
    $today = now();
    $thresholdTime = $today->copy()->setTime(8, 20, 59); // Set the threshold time to 8:20:59 AM today

    // Define the check-in time filter function
    $checkInTimeFilter = function ($checkin) use ($today, $thresholdTime) {
    return $checkin->created_at->isSameDay($today) &&
    $checkin->created_at->lessThanOrEqualTo($thresholdTime);
    };

    // Filter check-ins for today and time constraint using the filter function
    $earlyBirds = $users->map(function ($user) use ($checkInTimeFilter) {
    // Get the first check-in that meets the time constraint
    $todayCheckin = $user->checkins->filter($checkInTimeFilter)->first();

    // Only return users with a valid check-in
    if ($todayCheckin) {
    return [
    'name' => $user->name,
    'email'=>$user->email, // Include user name
    'checkin' => $todayCheckin // Include the first valid check-in
    ];
    }
    return null; // Return null if no valid check-in
    })->filter() // Filter out null values
    ->sortBy(function ($earlyBird) {
    return $earlyBird['checkin']->created_at; // Sort by the check-in time
    });
    @endphp

    <p id="monthAndYear" class="text-lg font-bold text-gray-900 truncate">
        Early Birds Club<span class="text-4xl"> 🦜</span>
    </p>
    <p class="text-sm text-gray-500 pb-6">
        <span class="motion-safe:animate-ping">🌅</span>See which early risers snagged the biggest worms
        <span class="text-2xl">🐛</span> today!
    </p>

    @if($earlyBirds->isNotEmpty())

    <ul class="divide-y divide-gray-200 w-full ">
        @foreach($earlyBirds as $earlyBird)
        <li class="py-3 sm:pb-4">
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <div class="flex-shrink-0">
                    🦜
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ ucfirst($earlyBird['name']) }}
                    </p>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                        {{ ucfirst($earlyBird['email']) }}
                    </p>
                </div>
                <div class="inline-flex items-center text-base font-semibold text-gray-900">
                    <span
                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded border border-green-400">
                        <x-bladewind::icon name="clock" type="solid" class="h-3 w-3" />
                        {{$earlyBird['checkin']->created_at->format('h:ia')}}
                    </span>
                </div>
            </div>
        </li>

        @endforeach
    </ul>
    @else
    <p>No early birds today!</p>
    @endif

</x-bladewind::card>