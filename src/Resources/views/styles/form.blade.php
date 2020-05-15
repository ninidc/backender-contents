@extends('architect::layouts.master')

@section('content')

<div id="form-builder"
    layout="{{ base64_encode(json_encode($layout)) }}"
    form="{{ base64_encode(json_encode($form)) }}"
    fields="{{ count($fields) > 0?base64_encode(json_encode($fields)):null }}"
></div>

@stop

@push('plugins')
    {{ Html::script('/modules/architect/plugins/dropzone/dropzone.min.js') }}
    {{ HTML::style('/modules/architect/plugins/dropzone/dropzone.min.css') }}
    {{ Html::script('/modules/architect/plugins/datatables/datatables.min.js') }}
    {{ HTML::style('/modules/architect/plugins/datatables/datatables.min.css') }}
    {{ Html::script('/modules/architect/plugins/bootbox/bootbox.min.js') }}
    {{ Html::script('/modules/architect/js/libs/datatabletools.js') }}
    {{ Html::script('/modules/architect/js/architect.js') }}
@endpush

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
