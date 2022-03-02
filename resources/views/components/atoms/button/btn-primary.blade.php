@props(['size'=>null, 'type'=>'button'])
<button type="{{$type}}" {{$attributes->class('btn btn-primary btn-active-color-gray-200')}}>{{$slot}}</button>
