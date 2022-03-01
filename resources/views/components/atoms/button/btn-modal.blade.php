@props(['type'=>'button', 'target'=>''])
<button type="{{$type}}" {{$attributes->class(['btn btn-primary'])}} data-bs-toggle="modal" data-bs-target="{{$target}}">{{$slot}}</button>
