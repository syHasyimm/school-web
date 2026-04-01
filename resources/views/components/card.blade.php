@props(['hover' => true])

<div {{ $attributes->merge(['class' => 'relative bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300 ' . ($hover ? 'hover:shadow-xl hover:-translate-y-1' : '')]) }}>
    {{ $slot }}
</div>
