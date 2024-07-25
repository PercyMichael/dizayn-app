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

                document.getElementById('time').textContent = formattedTime;
                document.getElementById('date').textContent = formattedDate;
            }, 1000);
        }

        startTimer();
    </script>

    <x-header />
    <div class="mx-auto max-w-screen-md grid md:grid-cols-1 gap-6 p-4">

        @if (session('successfull_checkin'))
        <x-bladewind::alert type="success" show_close_icon="true" class="text-sm">
            {{ session('successfull_checkin') }}
        </x-bladewind::alert>
        @endif


        @if (session('welcome'))
        <x-bladewind::alert type="success" show_close_icon="true" class="text-sm">
            {{ session('welcome') }}
        </x-bladewind::alert>

        @else
        <x-bladewind::card class="">
            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl">Hi, <span class="text-green-600 dark:text-green-500">{{ucfirst(Auth::user()->name)}}</span></h1>
            <p class="text-lg font-normal text-gray-500 lg:text-xl">See a detailed overview of your office check-ins for 2024.</p>
            @if ($checkedInToday==false)
            <div class="flex justify-between items-center py-4 border-t mt-4">
                <div class="flex flex-col">
                    <div id="time" class="font-extrabold text-lg text-green-500"></div>
                    <div id="date" class="text-sm text-gray-500"></div>
                    <span>
                        You havent checked in today!
                    </span>
                </div>
                <form action="/checkin" method="post">
                    @csrf
                    <x-bladewind.button size="medium" uppercasing="flase" class="animate-bounce" color="green" can_submit="true">
                        Checkin Now!
                    </x-bladewind.button>
                </form>
            </div>
            @endif
        </x-bladewind::card>


        @endif



    </div>

    <div class="mx-auto max-w-screen-md grid md:grid-cols-1 gap-6 px-4 py-8">

        <ul>
            @foreach ($checkinsByMonth as $month => $checkins)

            <h2>{{ date('F Y', strtotime($month)) }}</h2>
            <ul>
                @foreach ($checkins as $checkin)

                @endforeach
            </ul>
            @endforeach

        </ul>

        @foreach ($checkinsByMonth as $month => $checkins)
        <x-bladewind::card class="">
            <h2 class="font-bold text-lg py-4">{{ getmonth($month) }}</h2>
            <div class="grid grid-cols-7 gap-1 rounded-full">
                @foreach (getAllDaysInMonth($checkin->created_at) as $day)

                @php
                $bgColor = 'bg-white'; // default color if not in the database

                if ($day['day_of_month'] == getDay($checkin->created_at)) {
                $status = checkinStatus($checkin->created_at);
                if ($status == 'late') {
                $bgColor = 'bg-red-200';
                } else {
                $bgColor = 'bg-green-200';
                }
                }
                @endphp

                <div class="text-center border rounded-full aspect-square flex flex-col justify-center {{$bgColor}} relative md:w-20 md:h-20 w-14 h-14">
                    <span class="md:text-[9px] text-[8px]">{{ $day['day_of_week'] }}</span>
                    <span class="font-semibold font-abril">{{ $day['day_of_month'] }}</span>
                    <span class="md:text-[9px] text-[8px]">
                        {{getTime($checkin->created_at)}}
                    </span>
                </div>
                @endforeach
            </div>
        </x-bladewind::card>

        @endforeach
    </div>


</x-layout>