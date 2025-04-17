@props(['href'])

<a {{ $attributes->merge(['href' => $href, 'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600']) }}>
    {{ $slot }}
</a>
