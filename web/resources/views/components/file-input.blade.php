<!-- resources/views/components/file-input.blade.php -->
@props([
    'name',
    'label' => '',
    'id' => $name,
    'value' => null,
    'link' => null,
    'required' => false,
])

@php
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
    $extension = $link ? strtolower(pathinfo($link, PATHINFO_EXTENSION)) : null;
    $isImage = $extension && in_array($extension, $imageExtensions);
@endphp

<div class="form-group d-flex flex-column file-container">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <div class="div-file">
        <input
            type="file"
            name="{{ $name }}"
            id="{{ $id }}"
            class="form-control file"
            onchange="displaySelectedFile('{{ $id }}', 'selected_{{ $id }}')"
            {{ $required ? 'required' : '' }}
        >
    </div>

    {{-- @if ($link)
        <a href="{{ asset('storage/' . $link) }}" target="_blank" class="text-primary text-decoration-none mt-1">Ver archivo</a>
    @endif --}}

    @if ($link)
        <div class="d-flex align-items-center gap-2 mt-1">
            @if ($isImage)
                <img src="{{ asset('storage/' . $link) }}"
                    alt="Vista previa de {{ $label }}"
                    class="img-thumbnail"
                    style="max-width: 60px; max-height: 40px;">
            @elseif ($extension === 'pdf')
                <img src="{{ asset('img/pdf-icon.png') }}"
                    alt="Archivo PDF"
                    style="max-width: 40px; max-height: 40px;">
            @endif

            <a href="{{ asset('storage/' . $link) }}" target="_blank" class="text-primary text-decoration-none">
                Ver archivo
            </a>
        </div>
    @endif

    {{-- <span id="selected_{{ $id }}" class="text-danger hidden mt-1"></span> --}}
    <div id="selected_{{ $id }}" class="text-danger hidden mt-1"></div>
</div>
