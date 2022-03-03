@aware(['error', 'name'])
@props(['error'=>null, 'name'=>null])
<select name="{{$name}}" x-bind:id="$id('input')" {{ $attributes->class(['form-control', 'is-invalid'=>$errors->has($name)])->merge() }}>
    {{$slot}}
</select>
