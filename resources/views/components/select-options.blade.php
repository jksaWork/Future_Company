<div class='{{$class}}'>
    <div class="form-group">
        <label for="" class="fs-6 fw-bold mb-2"> {{ __('translation.' . $name) }} </label>
        <select class="form-control" @disabled($value ? true: false) name="{{ $name }}" id="status">
            @foreach ($options as $option)
                <option value="{{ is_string($option) ? $option : $option->id  }}"
                    @if(is_string($option))
                    {{-- @dd($option ,  $value) --}}
                        @if ($option == $value)
                            selected
                        @endif
                    @else
                        @if ($option == null)
                            selected
                        @endif
                    @endif
                    >
                {{is_string($option) ? __('translation.' . $option) : $option->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
