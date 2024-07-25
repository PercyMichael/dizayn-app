<div class="bg-white border-b border-gray-200">

    <nav class="flex justify-between max-w-screen-xl mx-auto p-3">
        <a href="">home</a>
        <form action="/signout" method="post">
            @csrf
            <x-bladewind.button outline="true" color="green" can_submit="true">Sign out</x-bladewind.button>
        </form>
    </nav>
</div>