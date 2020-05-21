@extends('backender:ui::layouts.master')

@section('content')
<div class="container grid-page">
    <div class="row">
        
        <div class="col-md-offset-2 col-md-8">

            <div class="page-title">
                <h1>{{Lang::get('backender::settings.title')}}</h1>
                <h3>{{Lang::get('backender::settings.subtitle')}}</h3>
            </div>

            <div class="grid-items">
                <div class="row">
                    {{-- Global settings --}}
                    @if(is_array(config('backender::settings')))
                        @foreach(config('backender::settings') as $setting)      
                            <div class="col-xs-3">
                                <a href="{{ isset($setting["route"]) ? route($setting["route"]) : null }}">
                                <div class="grid-item">
                                    <i class="fa {{ isset($setting["icon"]) ? $setting["icon"] : null }}"></i>
                                    <p class="grid-item-name">
                                        {{ isset($setting["label"]) ? $setting["label"] : null }}
                                    </p>
                                </div>
                                </a>
                            </div>
                        @endforeach()
                    @endif

                    {{-- Plugins settings --}}
                    @if(is_array(config('backender:contents::plugins.settings')))
                        @foreach(config('backender:contents::plugins.settings') as $setting)
                            @if(empty($setting['roles']) || has_roles($setting['roles']))
                                <div class="col-xs-3">
                                    <a href="{{ route($setting["route"]) }}">
                                        <div class="grid-item">
                                            <i class="fa {{ $setting["icon"] }}"></i>
                                            <p class="grid-item-name">
                                                {{ $setting["label"] }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach()
                    @endif()
                </div>
            </div>

        </div>

    </div>
</div>
@stop
