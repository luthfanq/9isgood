@props(['label', 'error'=>null, 'name'=>null, 'required'=>null])
<div
    x-data
    x-id="['input']"
    {{$attributes}}>
    <label x-bind:for="$id('input')" class="col-form-label {{$required}}">{{$label}}</label>
    {{ $slot }}
</div>
