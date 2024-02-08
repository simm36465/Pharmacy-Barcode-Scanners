<button {{ $attributes->merge(['type' => 'submit', 'class' => 'mt-3 btn btn-danger']) }}>
    {{ $slot }}
</button>
