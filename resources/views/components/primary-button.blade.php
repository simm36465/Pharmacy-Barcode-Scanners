<button {{ $attributes->merge(['type' => 'submit', 'class' => 'mt-2 btn btn-primary']) }}>
    {{ $slot }}
</button>
