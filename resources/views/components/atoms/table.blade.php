@props(['head'=>null, 'footer'=>null])
<table {{$attributes->class('table table-striped gx-7 border')}}>
    <thead class="text-center fw-bold border">
        {{$head}}
    </thead>
    <tbody class="border">
        {{$slot}}
    </tbody>
    @if($footer)
        <tfoot class="border">
            {{$footer}}
        </tfoot>
    @endif
</table>
