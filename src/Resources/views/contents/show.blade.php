@extends('backender:ui::layouts.master')

@section('content')
<div id="content-form"
    languages="{{ base64_encode(Backender\Contents\Entities\Language::getAllCached()) }}"
    tags="{{ isset($tags) ? base64_encode($tags->toJson()) : null }}"
    categories="{{ isset($categories) ? base64_encode(json_encode($categories)) : null }}"
    fields="{{ isset($fields) ? base64_encode($fields->toJson()) : null }}"
    page="{{ isset($page) ? base64_encode(json_encode($page, true)) : null }}"
    pages="{{ isset($pages) ? base64_encode(json_encode($pages,true)) : null }}"
    settings="{{ isset($settings) ? base64_encode($settings) : null }}"
    @if(isset($typology)) typology="{{base64_encode($typology->toJson())}}" @endif
    @if(isset($content)) content="{{base64_encode($content->toJson())}}" @endif
></div>
@stop

@push('javascripts-libs')
<script>
var routes = {
  'contents'                : "{{ route('contents') }}",
  'medias.data'             : "{{ route('medias.data') }}",
  'medias.index'            : '{{ route('medias.index') }}',
  'medias.store'            : '{{ route('medias.store') }}',
  'medias.show'             : '{{ route('medias.show') }}',
  'medias.delete'           : '{{ route('medias.delete') }}',
  'medias.update'           : '{{ route('medias.update') }}',
  'contents.data'           : '{{ route('contents.modal.data') }}',
  'showContent'             : "{{ route('contents.show',['id' => ':id']) }}",
  'contents.page.create'    : "{{ route('contents.page.create') }}",
  'contents.create'         : "{{ route('contents.create',['typology' => ':id']) }}",
  'previewContent'          : ASSETS+"preview/:id",
  'pagelayouts.data'        : '{{ route('pagelayouts.modal.data') }}'
};
</script>
@endpush
