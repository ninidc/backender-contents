@extends('architect::layouts.master')

@section('content')
<!-- React Component Medias/MediaEditModal -->
<div id="media-edit-modal" languages="{{ Backender\Contents\Entities\Language::getAllCached() }}" formats="{{ json_encode(config('images.formats')) }}"></div>

<div class="body medias">

    <div class="row">
        <div class="col-md-offset-1 col-md-10">

            <div class="card">
				<div class="card-body">

                    <h3 class="card-title">{{Lang::get('backender::media.list')}}</h3>
    				        <h6 class="card-subtitle mb-2 text-muted">{{Lang::get('backender::media.all_media')}}</h6>

                    <div class="medias-dropfiles" style="cursor:pointer;">
                        <p align="center" style="pointer-events:none;">
                            <strong>{{Lang::get('backender::fields.drag_file')}}</strong> <br />
                            <a href="#" class="btn btn-default"><i class="fa fa-upload"></i> &nbsp; {{Lang::get('backender::fields.upload_file')}}</a>
                        </p>
                    </div>

                    <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                        <span class="sr-only"></span>
                      </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-1 col-md-10" style="margin-top:30px;">
            <div class="card">
				<div class="card-body">
                    <table class="table" id="table-medias" data-url="{{route('medias.data')}}">
                        <thead>
                           <tr>
                               <th></th>
                               <th>{{Lang::get('backender::fields.filename')}}</th>
                               <th data-filter="select">{{Lang::get('backender::fields.tipus')}}</th>
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
        </div>
    </div>
</div>
@stop

@push('plugins')
    {{ Html::script('/modules/architect/plugins/dropzone/dropzone.min.js') }}
    {{ HTML::style('/modules/architect/plugins/dropzone/dropzone.min.css') }}

    {{ Html::script('/modules/architect/plugins/datatables/datatables.min.js') }}
    {{ HTML::style('/modules/architect/plugins/datatables/datatables.min.css') }}

    {{ Html::script('/modules/architect/js/libs/datatabletools.js') }}
    {{ Html::script('/modules/architect/js/architect.js') }}
@endpush

@push('javascripts-libs')
<script>
    architect.medias.init({
        'identifier' : '.medias-dropfiles',
        'table' : $('#table-medias'),
        'urls': {
          'index' : '{{ route('medias.index') }}',
          'store' : '{{ route('medias.store') }}',
          'show' : '{{ route('medias.show') }}',
          'delete' : '{{ route('medias.delete') }}',
          'update' : '{{ route('medias.update') }}'
        }
    })
</script>
@endpush

@push('stylesheets')

@endpush
