@props(['messages'])

@if ($messages)
    <p {{ $attributes->merge(['class' => 'mt-2 text-sm text-rose-600']) }}>
        {{ $messages }}
    </p>
@endif
