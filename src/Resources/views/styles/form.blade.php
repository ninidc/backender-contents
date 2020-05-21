@extends('backender:ui::layouts.master')

@section('content')

<div id="form-builder"
    layout="{{ base64_encode(json_encode($layout)) }}"
    form="{{ base64_encode(json_encode($form)) }}"
    fields="{{ count($fields) > 0?base64_encode(json_encode($fields)):null }}"
></div>

@stop


@push('javascripts')
<script>

  var routes = {
    'styles':"{{route('styles')}}",
    'medias.data' : "{{route('medias.data')}}",
    'medias.index' : '{{ route('medias.index') }}',
    'medias.store' : '{{ route('medias.store') }}',
    'medias.show' : '{{ route('medias.show') }}',
    'medias.delete' : '{{ route('medias.delete') }}',
    'medias.update' : '{{ route('medias.update') }}'
  };

  var csrf_token = "{{csrf_token()}}";

</script>

@endpush
