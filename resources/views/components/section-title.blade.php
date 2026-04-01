@props(['title', 'subtitle' => null, 'centered' => false])

<div class="mb-10 {{ $centered ? 'text-center' : '' }}">
    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $title }}</h2>
    @if($subtitle)
        <p class="text-lg text-gray-600 max-w-2xl {{ $centered ? 'mx-auto' : '' }}">{{ $subtitle }}</p>
    @endif
    <div class="mt-4 h-1 w-20 bg-primary-600 rounded-full {{ $centered ? 'mx-auto' : '' }}"></div>
</div>
