@aware(['error', 'name'])
@props(['name'=>''])
<input type="text" {{$attributes->class(['form-control tanggalan', 'is-invalid'=>$errors->has($name)])}} readonly>
@error($name) <span class="invalid-feedback">{{$message}}</span> @enderror
@push('custom-scripts')
    <script>
        $(".tanggalan").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: "DD-MMM-YYYY"
            }
        });
    </script>
@endpush
