@props(['title'=>null])
<div class="card">
    <div class="card-header">
        <div class="card-title">{{$title}}</div>
        @isset($toolbar)
        <div class="card-toolbar">
            {{$toolbar}}
        </div>
        @endisset
    </div>
    <div class="card-body">
        {{$slot}}
    </div>
    @isset($footer)
        <div class="card-footer">
            {{$footer}}
        </div>
    @endisset
</div>
