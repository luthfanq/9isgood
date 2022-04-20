@props([
    'title'=>null,
    'tabs'=>null
])
<div class="card">
    <div class="card-header card-header-stretch">
        <div class="card-title">{{$title}}</div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                {{$tabs}}
            </ul>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTab">
        {{$slot}}
        </div>
    </div>
</div>
