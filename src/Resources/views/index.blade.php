@extends('backender:ui::layouts.master')

@section('content')
<div class="container dashboard">
  <div class="row">
    <div class="col-md-offset-2 col-md-8">
      <div class="page-title">
        <h1>{{Lang::get('backender::home.wellcome')}} {{Auth::user()->firstname}},</h1>
        <h3>{{Lang::get('backender::home.current_state')}}</h3>
      </div>

      <div class="dashboard-items">
        <div class="row">
            <div class="col-xs-12">
              <!-- React SiteMap.js-->
              <div id="dashboard-sitemap"></div>
            </div>
        </div>
      </div>

    </div>
  </div>
  <div class="separator" style="height:60px;"></div>
</div>

@stop

@push('javascripts-libs')
<script src="/modules/architect/js/libs/d3/d3.v4.min.js"></script>
<script>
var routes = {
  'showContent' : "{{route('contents.show',['id' => ':id'])}}",
};
</script>
@endpush
