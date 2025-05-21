<!-- resources/views/components/date-input.blade.php -->
@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => null,
    'required' => false,
    'placeholder' => '',
    'icon' => 'fa-calendar-days',
    'addonClass' => '',
    'wrapperClass' => '',
    'minDate' => null,
    'maxDate' => null,
])

@php
    use Carbon\Carbon;

    // Si no se pasan minDate y maxDate, asignar valores dinámicos
    $minDate = $minDate ?: Carbon::now()->subYears(7)->format('Y-m-d');
    $maxDate = $maxDate ?: Carbon::now()->addYears(1)->format('Y-m-d');
@endphp

<div class="form-group {{ $wrapperClass }}">
    @if($label)
        <label for="{{ $id ?? $name }}" class="form-label" style="font-size: 15px">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <div class="input-group" id="calendar_{{ $id ?? $name }}" style="cursor: pointer;">
        <input
            type="date"
            name="{{ $name }}"
            id="{{ $id ?? $name }}"
            class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }} {{ $attributes->get('class') }}"
            value="{{ old($name, $value ?? '') }}"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            min="{{ $minDate }}"
            max="{{ $maxDate }}"
            {{ $attributes->except(['class', 'type']) }}
        >
        <span class="input-group-text {{ $addonClass }}">
            <i class="fa {{ $icon }}"></i>
        </span>
    </div>

    @error($name)
        <span class="invalid-feedback d-block text-xs">{{ $message }}</span>
    @enderror
</div>
