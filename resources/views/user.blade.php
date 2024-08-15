<x-layout>
    <x-header :users="$allUsers" />
    <div class="mx-auto max-w-screen-md grid md:grid-cols-1 gap-6 p-4">
        <x-bladewind::card class="">
            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-green-600 dark:text-green-500 md:text-5xl lg:text-6xl">{{ucfirst($username)}} <span class=" text-gray-900">'s</span></h1>
            <p class="text-lg font-normal text-gray-500 lg:text-xl">Detailed overview of check-ins for 2024.</p>
            <small class="text-gray-500">To account for the time it takes to turn on the computer,
                <span class="text-green-600 dark:text-green-500">5 minutes</span>
                have been subtracted</small>

            <div class="flex gap-x-5 py-1">
                <div class="flex items-center gap-x-1">
                    <x-bladewind::icon name="information-circle" type="solid" class="text-red-500" /><span class="text-sm text-gray-500">Late</span>
                </div>
                <div class="flex items-center gap-x-1">
                    <x-bladewind::icon name="information-circle" type="solid" class="text-green-500" /><span class="text-sm text-gray-500">Intime</span>
                </div>
            </div>
        </x-bladewind::card>
    </div>

    <div class="mx-auto max-w-screen-md grid md:grid-cols-1 gap-6 px-4 py-8">


        @foreach ($checkinsByMonth as $month => $checkins)
        <x-bladewind::card class="">
            <h2 class="font-bold text-lg py-4">{{ getmonth($month) }}</h2>
            <div class="grid grid-cols-7 gap-1 rounded-full">
                @foreach (getAllDaysInMonth($checkins->first()->created_at) as $day)
                @php
                $bgColor = 'bg-white'; // default color if not in the database
                $checkinForDay = $checkins->first(function ($checkin) use ($day) {
                return getDay($checkin->created_at) == $day['day_of_month'];
                });

                if ($checkinForDay) {
                $status = checkinStatus($checkinForDay->created_at->subMinutes(5));
                if ($status == 'late') {
                $bgColor = 'bg-red-100 text-red-800 border-red-400';
                } else {
                $bgColor = 'bg-green-100 text-green-800 border-green-400';
                }
                }
                @endphp

                <div @if($checkinForDay)
                    data-inverted data-tooltip="{{ getTime($checkinForDay->created_at) }}"
                    @endif id="day" class="text-center border rounded-full aspect-square flex flex-col justify-center relative md:w-20 md:h-20 w-14 h-14 {{ $bgColor }}">
                    <span class="md:text-[9px] text-[8px]">{{ $day['day_of_week'] }}</span>
                    <span class="font-semibold font-abril">{{ $day['day_of_month'] }}</span>
                    <span class="md:text-[9px] text-[8px]">
                        {{ $checkinForDay ? getTime($checkinForDay->created_at->subMinutes(5)) : '' }}
                    </span>
                </div>
                @endforeach
            </div>
        </x-bladewind::card>
        @endforeach

    </div>


</x-layout>