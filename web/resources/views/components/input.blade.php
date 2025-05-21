<!-- resources/views/components/input.blade.php -->
@unless($type === 'date')  <!-- Excluye inputs tipo date -->
    <div class="form-group">
        @if($label ?? false)
            <label for="{{ $id ?? $name }}" class="form-label" style="font-size: 15px">
                {{ $label }}
                @if($required ?? false)
                    <span class="text-danger">*</span>
                @endif
            </label>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $id ?? $name }}"
            placeholder="{{ $placeholder ?? '' }}"
            value="{{ old($name, $value ?? '') }}"
            @if($autocomplete ?? false)
                autocomplete="{{ $autocomplete }}"
            @endif
            @if($required ?? false) required @endif
            {{ $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
        >

        @error($name)
            <span class="invalid-feedback d-block text-xs">{{ $message }}</span>
        @enderror
    </div>
@endunless
