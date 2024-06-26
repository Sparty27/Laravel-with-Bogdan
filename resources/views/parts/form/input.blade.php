<label class="form-control w-full @if(isset($small)) max-w-xs @endif">
    @if(isset($title))
    <div class="label">
        <span class="label-text">{{ $title }}</span>
    </div>
    @endif
    <div class="flex items-center relative">
        <input type="text" placeholder="{{ $title ?? 'Type here' }}" class="{{ $class ?? '' }} input input-bordered w-full
                @if(isset($small)) input-sm max-w-xs @endif
                @error($model) input-error @enderror"
                @if(isset($type) && $type == 'money')
                    x-mask:dynamic="$money($input, '.', ' ')"
                @endif
                wire:model.live="{{ $model }}"/>
        @if(isset($type) && $type == 'money')
            <span class="absolute right-3 text-2xl">₴</span>
        @endif
    </div>
    @error($model)
    <div class="label">
        <span class="label-text-alt text-red-500">{{ $message }}</span>
    </div>
    @enderror
</label>
