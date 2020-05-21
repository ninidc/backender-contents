@extends('backender:ui::layouts.master')

@section('content')
<div class="container leftbar-page">
  <div class="col-xs-offset-2 col-xs-8 page-content">

    <h3 class="card-title">{{Lang::get('backender::settings.languages')}}</h3>
    <a href="{{route('languages.create')}}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> &nbsp; {{Lang::get('backender::language.add_language')}}</a>

    <table class="table" id="table" data-url="{{route('languages.data')}}">
        <thead>
           <tr>
               <th></th>
               <th>{{Lang::get('backender::datatables.name')}}</th>
               <th>{{Lang::get('backender::datatables.iso')}}</th>
               <th></th>
           </tr>
        </thead>
        <tfoot>
           <tr>
               <th></th>
               <th></th>
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
    architect.languages.init({
        'table' : $('#table')
    })
</script>
@endpush
