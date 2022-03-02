@props(['align'=>null, 'width'=>null])
<td {{$attributes->class('text-'.$align)}} width="{{$width}}">{{$slot}}</td>
