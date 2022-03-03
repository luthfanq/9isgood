@props(['size'=>null, 'type'=>'button'])
<a type="{{$type}}" {{$attributes->class('btn btn-primary btn-active-color-gray-200')}}>{{$slot}}</a>
