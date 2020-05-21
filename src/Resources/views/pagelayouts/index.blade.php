@extends('backender:ui::layouts.master')

@section('content')
<div class="container leftbar-page">
  <div class="col-xs-offset-2 col-xs-8 page-content">

    <h3 class="card-title">{{Lang::get('backender::fields.layouts')}}</h3>

    <table class="table" id="table" data-url="{{route('pagelayouts.data')}}">
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
    architect.pageLayouts.init({
        'table' : $('#table')
    })
</script>
@endpush
