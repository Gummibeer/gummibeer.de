<footer class="bg-white dark:bg-night-10 w-full py-4 md:py-6 px-4 md:px-8 lg:px-10 xl:px-12 text-snow-20 dark:text-snow-10">
    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
        <div class="flex-grow py-1 text-sm">
            &copy; Copyright 2015 - {{ date('Y') }} by Tom Witkowski
        </div>
        <ul class="flex flex-row list-inline space-x-2">
            <li>
                <a
                    href="https://twitter.com/devgummibeer"
                    target="_blank"
                    rel="noreferrer noopener"
                    class="hover:text-brand block p-1"
                    title="Twitter"
                >
                    <x-icon class="fab fa-twitter"/>
                    <span class="sr-only">Twitter</span>
                </a>
            </li>
            <li>
                <a
                    href="https://github.com/Gummibeer"
                    target="_blank"
                    rel="noreferrer noopener"
                    class="hover:text-brand block p-1"
                    title="GitHub"
                >
                    <x-icon class="fab fa-github"/>
                    <span class="sr-only">GitHub</span>
                </a>
            </li>
            <li>
                <a
                    href="https://strava.com/athletes/22896286"
                    target="_blank"
                    rel="noreferrer noopener"
                    class="hover:text-brand block p-1"
                    title="Strava"
                >
                    <x-icon class="fab fa-strava"/>
                    <span class="sr-only">Strava</span>
                </a>
            </li>
            <li>
                <a
                    href="https://steamcommunity.com/id/gummibeer"
                    target="_blank"
                    rel="noreferrer noopener"
                    class="hover:text-brand block p-1"
                    title="Steam"
                >
                    <x-icon class="fab fa-steam"/>
                    <span class="sr-only">Steam</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="flex flex-col sm:flex-row sm:justify-between space-y-4 sm:space-y-0 sm:space-x-4 mt-4 sm:mt-2">
        <ul class="flex flex-col sm:flex-row list-inline space-y-2 sm:space-y-0 sm:space-x-4 text-xs">
            <li>
                <x-icon class="fal mr-1 fa-mobile"/>
                <a href="tel:+491621525105" class="hover:text-brand">+49 162 1525105</a>
            </li>
            <li>
                <x-icon class="fal mr-1 fa-at"/>
                <a href="mailto:dev@gummibeer.de" class="hover:text-brand">dev@gummibeer.de</a>
            </li>
            <li>
                <x-icon class="fab mr-1 fa-telegram-plane"/>
                <a href="https://t.me/gummibeer" class="hover:text-brand">@gummibeer</a>
            </li>
        </ul>
        <ul class="flex flex-row list-inline space-x-4 text-xs">
            <li><a href="https://t.me/GummibeerDev" class="hover:text-brand">Newsletter</a></li>
            <li><a href="{{ route('imprint') }}" class="hover:text-brand">Imprint</a></li>
            <li><a href="{{ route('privacy') }}" class="hover:text-brand">Privacy</a></li>
        </ul>
    </div>
</footer>