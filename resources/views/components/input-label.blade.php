@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-semibold text-[#303030]']) }}>
    {{ $value ?? $slot }}
</label>
