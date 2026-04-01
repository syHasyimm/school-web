@props([
    'type' => 'default',
    'size' => 'sm',
    'dot' => false,
    'pill' => true,
])

@php
    $colors = match($type) {
        'success', 'accepted' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'danger', 'rejected' => 'bg-red-50 text-red-700 ring-red-600/20',
        'warning', 'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        'info' => 'bg-sky-50 text-sky-700 ring-sky-600/20',
        'primary' => 'bg-primary-50 text-primary-700 ring-primary-600/20',
        'secondary' => 'bg-gray-50 text-gray-600 ring-gray-500/20',
        'published' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'draft' => 'bg-gray-50 text-gray-600 ring-gray-500/20',
        default => 'bg-gray-50 text-gray-600 ring-gray-500/20',
    };

    $dotColor = match($type) {
        'success', 'accepted', 'published' => 'bg-emerald-500',
        'danger', 'rejected' => 'bg-red-500',
        'warning', 'pending' => 'bg-amber-500',
        'info' => 'bg-sky-500',
        'primary' => 'bg-primary-500',
        default => 'bg-gray-500',
    };

    $sizeClasses = match($size) {
        'xs' => 'text-[10px] px-1.5 py-0.5',
        'sm' => 'text-xs px-2 py-0.5',
        'md' => 'text-sm px-2.5 py-1',
        'lg' => 'text-base px-3 py-1.5',
        default => 'text-xs px-2 py-0.5',
    };

    $roundedClass = $pill ? 'rounded-full' : 'rounded-md';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-x-1.5 font-semibold ring-1 ring-inset {$colors} {$sizeClasses} {$roundedClass}"]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
    @endif
    {{ $slot }}
</span>
