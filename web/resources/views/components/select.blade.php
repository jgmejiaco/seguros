<div class="form-group">
    @if($label ?? false)
        <label for="{{ $name }}" class="form-label" style="font-size: 15px">
            {{ $label }}
            @if($required ?? false)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        class="form-select select2 {{ $errors->has($name) ? 'is-invalid' : '' }}"
        {{ $attributes }}
    >
        {{ $slot }}
    </select>

    @error($name)
        <span class="text-danger text-xs">{{ $message }}</span>
    @enderror
</div>
