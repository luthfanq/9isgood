@props(['size'=>null, 'type'=>'button'])
<button type="{{$type}}" {{$attributes->class('btn btn-info')}}>{{$slot}}</button>
