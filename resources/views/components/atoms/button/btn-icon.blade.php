@props(['button'=>'button', 'color'=>'primary'])
<button type="{{$button}}" {{$attributes->class('btn btn-flush btn-icon-'.$color)}}>{{$slot}}</button>
