@extends('backender:ui::layouts.master')

@section('content')
    <div id="typology-form"
        @if((isset($typology)) && $typology)typology={{base64_encode($typology->toJson())}}@endif
    ></div>
@stop

@push('javascripts-libs')
<script>
var routes = {
  'typologies' : "{{route('typologies')}}",
  'showTypology' : "{{route('typologies.show',['id' => ':id'])}}"
};
</script>

@endpush
