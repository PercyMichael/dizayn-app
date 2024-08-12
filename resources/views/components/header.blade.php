<div class="bg-white border-b border-gray-200">

    <nav class="flex justify-between max-w-screen-xl mx-auto p-3">
        <div class="flex justify-center items-center gap-x-6">
            <div class="flex space-x-2 items-center rounded-md">
                <div class="grow flex gap-x-1">
                    <a href="/"><x-bladewind::icon name="HOME" /> HOME</a>
                </div>
            </div>


            <x-bladewind::dropmenu position="right" height="150" width="300" padded="true">



                @if (isset($users) && count($users) > 0)
                <x-slot:trigger>
                    <div class="flex space-x-2 items-center rounded-md">
                        <div class="grow">
                            <x-bladewind::icon name="users" /> MEMBERS ({{$users->count()}})
                        </div>
                        <div>
                            <x-bladewind.icon name="chevron-down" class="!h-4 !w-4" />
                        </div>
                    </div>
                </x-slot:trigger>
                @foreach ($users as $user)
                <a href="/user/{{$user->name}}/{{$user->id}}">
                    <x-bladewind::dropmenu-item class="w-48">
                        <div class="grow">
                            <div><strong>{{ ucfirst($user->name) }}</strong></div>
                            <div class="text-sm">{{ $user->email }}</div>
                        </div>
                    </x-bladewind::dropmenu-item>
                </a>
                @endforeach
                @else
                <p>No users found.</p>
                @endif

            </x-bladewind::dropmenu>
        </div>

        <form action="/signout" method="post">
            @csrf
            <x-bladewind.button color="green" can_submit="true">Sign out</x-bladewind.button>
        </form>
    </nav>
</div>