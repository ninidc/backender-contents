@extends('backender:ui::layouts.master')

@section('content')


<div class="container leftbar-page">

  @include('backender:contents::partials.content-nav',['typologies' => $typologies])

  <div class="col-xs-offset-2 col-xs-10 page-content">
    <h3 class="card-title">{{Lang::get('backender::fields.tags')}}</h3>
    <a href="{{route('tags.create')}}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> &nbsp; {{Lang::get('backender::tag.add')}}</a>

    <table class="table" id="table-tags" data-url="{{route('tags.data')}}">
        <thead>
           <tr>
               <th>{{Lang::get('backender::fields.name')}}</th>
               <th></th>
           </tr>
        </thead>
        <tfoot>
           <tr>
               <th></th>
               <th></th>
           </tr>
        </tfoot>
    </table>
  </div>
</div>
@stop


@push('javascripts-libs')
<script>
    architect.tags.init({
        'table' : $('#table-tags'),
        'urls': {
            'index' : '{{ route('contents.data') }}',
            'show' : '{{ route('contents.show') }}',
            'delete' : '{{ route('contents.delete') }}',
        }
    })
</script>
@endpush
