@props(['align' => 'right', 'width' => '48'])

@php
    $alignmentClasses = [
        'left' => 'origin-top-left left-0',
        'right' => 'origin-top-right right-0',
    ][$align] ?? 'origin-top-right right-0';

    $widthClass = match($width) {
        '48' => 'w-48',
        default => $width,
    };
@endphp

<div class="relative" x-data="{ open: false }">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 mt-2 rounded-md shadow-lg {{ $widthClass }} {{ $alignmentClasses }}"
        style="display: none;"
    >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white dark:bg-gray-700 py-1">
            {{ $content }}
        </div>
    </div>
</div>
