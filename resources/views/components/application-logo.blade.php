@props(['class' => 'w-12 h-12'])

<div {{ $attributes->merge(['class' => $class]) }}>
    {!! file_get_contents(public_path('images/icons/film-solid.svg')) !!}
</div>

<style>
    /* Ensure the SVG scales correctly and inherits text color */
    div svg {
        width: 100%;
        height: 100%;
        fill: currentColor;
    }
</style>
