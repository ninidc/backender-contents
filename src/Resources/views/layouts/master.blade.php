<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{env('APP_NAME')}}</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex,nofollow">

        <!-- Global style -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

        <link rel="stylesheet" media="all" href="{{ asset('modules/architect/css/app.css')}}" />
        <link rel="stylesheet" media="all" href="{{ asset('modules/extranet/css/back-style.css')}}" />

        <!-- Fonts -->
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" crossorigin="anonymous">

        @include('architect::layouts.jsconst')
        @include('extranet::layouts.jsconst')

        <!-- Jquery -->
        <script src="{{ asset('modules/architect/plugins/jquery/jquery-3.2.1.min.js') }}"></script>

        <!-- Toastr -->
        <script src="{{ asset('modules/architect/plugins/toastr/toastr.min.js') }}"></script>
        <link href="{{ asset('modules/architect/plugins/toastr/toastr.min.css')}}" rel="stylesheet" media="all"  />
        {{ Html::script('/modules/architect/plugins/bootbox/bootbox.min.js') }}

        <!-- Language -->
        {{ Html::script('/modules/architect/js/lang.dist.js') }}
        <script>
            Lang.setLocale('{{App::getLocale()}}');
        </script>

        <!-- code to fix jquery slowing down the browser -->
        <script>
          $(function(){
            jQuery.event.special.touchstart = {
              setup: function( _, ns, handle ){
                if ( ns.includes("noPreventDefault") ) {
                  this.addEventListener("touchstart", handle, { passive: false });
                } else {
                  this.addEventListener("touchstart", handle, { passive: true });
                }
              }
            };


            var error = "";

            @if(isset($errors))

                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        error += "- {{$error}}<br/>";
                    @endforeach
                @endif
            @endif

            @if(Session::has('notify_error'))
                error += "- {{ Session::get('notify_error') }}<br/>";
            @endif

            if(error != '')
              toastr.error(error, 'Error', {timeOut: 10000});

            @if(Session::has('notify_success'))
              toastr.success("{{ Session::get('notify_success') }}", 'Success', {timeOut: 3000});
            @endif

          });

        </script>

        <!-- App -->
        <script src="{{ asset('modules/architect/js/app.js') }}" defer></script>
        <script src="{{ asset('modules/extranet/js/back-app.js') }}" defer></script>

        @stack('stylesheets')

        @stack('plugins')
    </head>

    <body>
        <div id="app">

            @yield('modal')

            <section id="wrapper">
                <section id="main">

                    @if(Auth::user())
                        @if(!isset($hideTopbar) || (isset($hideTopbar) && $hideTopbar === false))
        	        	      @include('architect::layouts.topbar')
                        @endif
                    @endif

    	        	<section id="content">
    	        		@yield('content')
    	        	</section>
    	        </section>
            </section>
        </div>
        @include('architect::partials.styles.back')
        @stack('javascripts-libs')
        @stack('javascripts')
    </body>
</html>
