{{--<div class="w-full bg-base-300 flex justify-center">--}}
<div class="w-full bg-[#5A72A0] flex justify-center">
    <div class="navbar max-w-screen-2xl">
        <div class="flex-none lg:hidden hidden">
            <label for="my-drawer-" aria-label="open sidebar" class="btn btn-square btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </label>
        </div>
        <div class="flex-1 px-2 mx-2">
            <a href="/shop" class="cursor-pointer">
                <img src="{{ asset('images/logo.svg') }}" alt="logo" width="200">
            </a>
        </div>
        <div>
            <a href="/admin" class="cursor-pointer max-sm:px-2 px-4 py-2 max-sm:mr-1 mr-3 rounded-lg hover:bg-[#546A96]">
                <i class="ri-admin-line cursor-pointer text-2xl text-white"></i>
            </a>

            <div class="flex-none lg:block">
                <ul class="menu menu-horizontal">
                    <!-- Navbar menu content here -->
                    <li>
                        @livewire('basket-widget')
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
