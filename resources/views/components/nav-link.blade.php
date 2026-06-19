@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors text-white bg-gray-700'
            : 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors text-gray-300 hover:text-white hover:bg-gray-800';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
