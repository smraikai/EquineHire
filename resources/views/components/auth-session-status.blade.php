@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-blue-600']) }}>
        {{ $status }}
    </div>
@endif
