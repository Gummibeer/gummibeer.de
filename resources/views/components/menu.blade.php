<header class="bg-white dark:bg-night-10 shadow sticky top-0 left-0 right-0 z-10">
    <nav class="px-4 md:px-8 lg:px-10 xl:px-12 flex flex-wrap md:flex-no-wrap md:justify-between" x-data="{show: false}" :class="{'h-screen': show}">
        <div class="flex-grow md:flex-auto">
            <a href="{{ route('home') }}" class="inline-block font-logo text-2xl md:text-3xl leading-none tracking-wider py-4">
                Tom Witkowski
            </a>
        </div>

        <div class="my-1 md:hidden" :class="{'mm-wrapper_opened': show}">
            <button class="block md:hidden mburger mburger--squeeze" @click="show = !show" type="button" aria-controls="menu-list" :aria-expanded="show ? 'true' : 'false'" aria-label="toggle main menu visibility">
                <b></b>
                <b></b>
                <b></b>
                <span class="sr-only">main menu visibility toggle</span>
            </button>
        </div>

        <div class="h-0 flex-basis-full md:hidden"></div>

        <ul class="md:flex w-full md:w-auto list-none md:space-x-4" :class="{'flex flex-col': show, 'hidden': !show}" id="menu-list">
            @foreach([
                '/' => 'Home',
                'me' => 'Me',
                'blog' => 'Blog',
                'uses' => 'Uses',
            ] as $route => $name)
            <li>
                <a
                    href="{{ url($route) }}"
                    class="@if(request()->is($route.'*')) text-brand @else text-black dark:text-white hover:text-brand @endif font-bold text-2xl md:text-lg text-center leading-none block py-6 px-4"
                >{{ $name }}</a>
            </li>
            @endforeach
        </ul>
    </nav>
</header>