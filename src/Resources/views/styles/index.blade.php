@extends('backender:ui::layouts.master')

@php
    $styles = \Backender\Contents\Entities\Style::all();
@endphp

@section('content')
  <div class="container grid-page">
  <div class="row">
    <div class="col-md-offset-2 col-md-8">

      <div class="page-title">
        <h1>Styles</h1>
      </div>

      <div class="grid-items">
        <div class="row">
          @foreach($styles as $style)
            <div class="col-xs-3">
                <a href="{{ route('style.show', $style->identifier) }}">
                  <div class="grid-item">
                      <i class="fa {{  $style->icon }}"></i>
                      <p class="grid-item-name">
                          {{ $style->identifier }}
                      </p>
                  </div>
                </a>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

