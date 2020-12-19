<aside class="relative bg-brand text-night-0 py-2 px-4 md:px-8 lg:px-10 xl:px-12 flex flex-row justify-between items-center space-x-2  text-sm">
    <p>
        Never want to miss a post?
        <span class="hidden sm:inline">You can join my Telegram channel.</span>
    </p>
    <a href="https://t.me/GummibeerDev" class="flex items-center bg-white rounded-1 p-1 sm:p-2">
        <x-icon class="fab fa-telegram-plane mr-1"/>
        <span class="leading-none">subscribe</span>
    </a>
</aside>

<header class="bg-white dark:bg-night-10 shadow sticky top-0 left-0 right-0 z-10">
    <nav
        class="px-4 md:px-8 lg:px-10 xl:px-12 flex flex-col md:flex-row flex-no-wrap md:justify-between"
        x-data="{show: false}"
        :class="{'h-screen': show}"
    >
        <div class="flex-shrink flex flex-row w-full">
            <div class="flex flex-grow md:flex-auto items-center">
                <a href="{{ route('home') }}" class="inline-block font-logo text-2xl lg:text-3xl leading-none tracking-wider py-4 whitespace-no-wrap">
                    Tom Witkowski
                </a>
            </div>

            <div class="my-1 md:hidden" :class="{'mm-wrapper_opened': show}">
                <button
                    type="button"
                    class="block md:hidden mburger mburger--squeeze"
                    @click="show = !show"
                    aria-controls="menu-list"
                    :aria-expanded="show ? 'true' : 'false'"
                    aria-label="toggle main menu visibility"
                >
                    <b></b>
                    <b></b>
                    <b></b>
                    <span class="sr-only">main menu visibility toggle</span>
                </button>
            </div>
        </div>

        <ul
            class="flex flex-col md:flex-row w-full md:w-auto list-none md:space-x-2 lg:space-x-4 x-cloak md:-x-cloak"
            :class="{'hidden md:flex': !show}"
            x-cloak
            id="menu-list"
        >
            @foreach([
                '/' => 'Home',
                'resume' => 'Resume',
                'blog' => 'Blog',
                'portfolio' => 'Portfolio',
                'charity' => 'Charity',
                'uses' => 'Uses',
            ] as $route => $name)
            <li class="flex items-center">
                <a
                    href="{{ url($route) }}"
                    class="@if(request()->is($route.'*')) text-brand @else text-black dark:text-white hover:text-brand @endif font-bold text-2xl md:text-lg text-center leading-none block w-full py-6 px-4 md:px-3 lg:px-4"
                >{{ $name }}</a>
            </li>
            @endforeach
        </ul>
    </nav>
</header>