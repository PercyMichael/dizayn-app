<x-layout>
    <script>
        function startTimer() {
            const now = new Date();
            let seconds = now.getSeconds();
            let minutes = now.getMinutes();
            let hours = now.getHours() % 12 || 12;
            const period = now.getHours() >= 12 ? 'PM' : 'AM';
            const dayOfWeek = new Intl.DateTimeFormat('en-US', {
                weekday: 'long'
            }).format(now);
            const dayOfMonth = now.getDate();
            const month = new Intl.DateTimeFormat('en-US', {
                month: 'short'
            }).format(now);
            const year = now.getFullYear();

            const timer = setInterval(() => {
                seconds++;
                if (seconds === 60) {
                    seconds = 0;
                    minutes++;
                }
                if (minutes === 60) {
                    minutes = 0;
                    hours++;
                }
                if (hours === 12) {
                    period = period === 'AM' ? 'PM' : 'AM';
                }

                const formattedTime = `${hours}:${minutes}:${seconds < 10 ? '0' + seconds : seconds} ${period}`;
                const formattedDate = `${dayOfWeek}, ${dayOfMonth} ${month}, ${year}`;
                const monthAndYear = `${month}, ${year}`;
                console.log('====================================');
                console.log(monthAndYear);
                console.log('====================================');

                document.getElementById('time').textContent = formattedTime;
                document.getElementById('date').textContent = formattedDate;
                document.getElementById('monthAndYear').textContent = monthAndYear;
            }, 1000);
        }

        startTimer();
    </script>

    <x-header :users="$allUsersWithCheckins" />

    <div class="mx-auto max-w-screen-xl flex flex-col md:flex-row gap-6 px-4 py-8 justify-center">

        <!-- <div class="right-card w-1/5">
            <x-bladewind::card class="">Hi</x-bladewind::card>
        </div> -->

        <div class="middle-grid flex flex-col gap-y-5">
            @if (session('welcome'))
            <x-bladewind::alert type="success" show_close_icon="true" class="text-sm">
                {{ session('welcome') }}
            </x-bladewind::alert>
            @endif

            @if (session('successfull_checkin'))
            <script>
                showNotification(
                        'Success',
                        "{{ session('successfull_checkin') }}"
                    );
            </script>
            <x-bladewind::alert type="success" show_close_icon="true" class="text-sm">
                {{ session('successfull_checkin') }}
            </x-bladewind::alert>
            @endif

            <x-bladewind::card>
                <x-tab />
            </x-bladewind::card>


            <!-- TOP CARD -->
            <x-bladewind::card>
                <h1
                    class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl">
                    Hi, <span class="text-green-600 dark:text-green-500">{{ ucfirst(Auth::user()->name) }}</span>
                </h1>
                <p class="text-lg font-normal text-gray-600 lg:text-xl">See a detailed overview of your office check-ins
                    for 2024.</p>

                <small class="text-gray-500">To account for the time it takes to turn on the computer,
                    <span class="text-green-600 dark:text-green-500">5 minutes</span>
                    have been subtracted</small>
                @if ($checkedInToday == false)
                <div class="flex md:flex-row flex-col md:items-center justify-between py-4 border-t mt-4 gap-y-4">
                    <div class="flex flex-col">
                        <!-- CURENT DATE AND TIME -->
                        <div id="time" class="font-extrabold text-lg text-green-500"></div>
                        <div id="date" class="text-sm text-gray-500"></div>
                        <!-- SEND CURENT DATE AND TIME -->
                        <span>
                            You havent checked in today!
                        </span>
                    </div>

                    <form action="/checkin" method="post">
                        @csrf
                        <x-bladewind.button class="w-full" size="medium" uppercasing="flase" color="green"
                            can_submit="true">
                            Checkin Now!
                        </x-bladewind.button>
                    </form>
                </div>
                @endif


                <div class="flex gap-x-5 justify-center">

                    <div class="flex items-center gap-x-1">
                        <x-bladewind::icon name="information-circle" type="solid" class="text-green-500" /><span
                            class="text-sm text-gray-500">Intime</span>
                    </div>
                    <div class="flex items-center gap-x-1">
                        <x-bladewind::icon name="information-circle" type="solid" class="text-red-500" /><span
                            class="text-sm text-gray-500">Late</span>
                    </div>
                    <div class="flex items-center gap-x-1">
                        <x-bladewind::icon name="information-circle" type="solid" class="text-blue-500" /><span
                            class="text-sm text-gray-500">Absent</span>
                    </div>
                </div>
            </x-bladewind::card>
            <!-- END TOP CARD -->

            <!-- EARLY BIRD CARD -->
            <x-early-bird :users="$allUsersWithCheckins" />
            <!-- END EARLY BIRD CARD -->

            <!-- MONTH CARD -->
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

                    $currentLoopedDate = Carbon\Carbon::createFromFormat('F j', getmonth($month) . ' ' .
                    $day['day_of_month']);
                    $isBeforeOrEqualToday = $currentLoopedDate->lessThanOrEqualTo(now()->startOfDay());

                    $weekend=false;

                    if ($checkinForDay) {
                    $status = checkinStatus($checkinForDay->created_at->subMinutes(5));
                    if ($status == 'late') {
                    $bgColor = 'bg-red-100 text-red-800 border-red-400';
                    } else {
                    $bgColor = 'bg-green-100 text-green-800 border-green-400';
                    }
                    }

                    if ($day['day_of_week'] == 'Sat' || $day['day_of_week'] == 'Sun') {
                    $weekend=true;
                    }
                    @endphp

                    <div @if ($checkinForDay) data-inverted data-tooltip="{{ getTime($checkinForDay->created_at) }}"
                        @endif id="day"
                        class="text-center border cursor-pointer rounded-full aspect-square flex flex-col justify-center relative md:w-20 md:h-20 w-14 h-14 {{$checkinForDay == null && $isBeforeOrEqualToday && $weekend==false ? 'bg-blue-100 text-blue-800 border-blue-400' : $bgColor }}">
                        <span class="md:text-[9px] text-[8px]">{{ $day['day_of_week'] }}</span>
                        <span class="font-semibold font-abril">{{ $day['day_of_month'] }}</span>
                        <span class="md:text-[9px] text-[8px]">
                            {{ $checkinForDay ? getTime($checkinForDay->created_at->subMinutes(5)) : ($weekend ?
                            'Weekend' : ($checkinForDay == null && $isBeforeOrEqualToday ? 'Absent' : '')) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </x-bladewind::card>
            @endforeach
            <!-- END MONTH OF CARD -->
        </div>

        <!-- RIGHT CARD -->
        {{-- <div class="right-card w-full md:w-1/4">
            <x-right-card :users="$allUsersWithCheckins" />
        </div> --}}
        <!-- END RIGHT CARD -->

    </div>


</x-layout>