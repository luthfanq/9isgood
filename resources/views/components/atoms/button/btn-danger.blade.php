@props(['size'=>null, 'type'=>'button'])
<button type="{{$type}}" {{$attributes->class('btn btn-danger btn-active-color-gray-200')}}>{{$slot}}</button>
