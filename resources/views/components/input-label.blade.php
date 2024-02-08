@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-solid text-base text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
