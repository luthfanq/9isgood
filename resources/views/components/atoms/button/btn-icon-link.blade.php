@props(['button'=>'button', 'color'=>'primary', 'href'=>'#'])
<a href="{{$href}}" {{$attributes->class('btn btn-flush btn-icon-'.$color)}}>{{$slot}}</a>
