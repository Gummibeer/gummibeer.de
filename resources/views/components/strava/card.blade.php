<div class="rounded-4 shadow bg-white dark:bg-night-20 overflow-hidden p-4 flex flex-row items-center space-x-4">
    <x-icon :class="'fal fa-3x text-snow-20 dark:text-snow-10 '.$icon"/>
    <div class="flex-grow">
        <span class="block text-xl">{{ $label }}</span>
        <div>
            <strong class="font-mono text-brand text-3xl">{{ round($value) }}</strong>
            <span class="text-snow-20 dark:text-snow-10 mb-4">{{ $unit }}</span>
        </div>
    </div>
</div>