@props(['for'])

<ul class="text-red-500 {{$for}}-errors">
    @error($for)
        <li class="error">{{ $message }}</li>
    @enderror
</ul>
