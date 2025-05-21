<!-- resources/views/components/form.blade.php -->
@props([
    'method' => 'POST',
    'action' => '#',
    'id' => null,
    'class' => '',
    'hasFiles' => false, // agregamos valor por defecto aquí
])

@php
    $formMethod = strtoupper($method);
    $spoofMethod = in_array($formMethod, ['PUT', 'PATCH', 'DELETE']);
    $enctype = $hasFiles ? 'multipart/form-data' : null; // 👈 definimos el enctype limpio
@endphp

<form
    method="{{ $spoofMethod ? 'POST' : $formMethod }}"
    action="{{ $action }}"
    id="{{ $id }}"
    class="{{ $class }}"
    autocomplete="off"
    {{-- @if($hasFiles) enctype="multipart/form-data" @endif --}}
    @if ($enctype) enctype="{{ $enctype }}" @endif
    {{ $attributes }}
>
    @if($formMethod !== 'GET')
        @csrf
        @if($spoofMethod)
            @method($formMethod)
        @endif
    @endif

    {{ $slot }}
</form>
