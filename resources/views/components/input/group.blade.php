@props(['label', 'error'=>null, 'name'=>null])
<div
    x-data
    x-id="['input']"
    {{$attributes}}>
    <label x-bind:for="$id('input')" class="col-form-label">{{$label}}</label>
    {{ $slot }}
</div>
