@php
  $storedStylesBack = \Cache::get('backStyles');
@endphp

@if(!$storedStylesBack)
  @php
    $seconds = 24*3600;
    $style = \Backender\Contents\Entities\Style::where('identifier','back')->first();
    $storedStylesBack = (new \Backender\Contents\Transformers\StyleFormTransformer($style))->toArray();
    \Cache::put('backStyles', $storedStylesBack, $seconds);
  @endphp
@endif
<header>
    <div class="topnav">

        {{-- TOP NAV BAR --}}
        <div class="topnav-top">
            <div class="container">
              <div class="row">

                <div id="logo-wrapper" class="col-xs-2">
                  <a href="{{route('home')}}" class="logo-link">
                    @if(isset($storedStylesBack['backLogo']) && isset($storedStylesBack['backLogo']->value))
                      <img src="/{{$storedStylesBack['backLogo']->value->urls['original']}}" alt="Logo" />
                    @else
                      <img src="{{asset('modules/architect/images/client-logo.jpg')}}" alt="Logo" />
                    @endif
                  </a>
                </div>

                <div class="col-xs-8">
                  <nav class="main-nav">
                    <ul>
                        @include('architect::partials.topbar-menu')
                    </ul>
                  </nav>
                </div>

                <div class="col-xs-2">

                  <div class="topbar-right">

                    <div class="navbar-collapse">
                      <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              {{substr(Auth::user()->lastname,0,15)}}
                              {{strlen(Auth::user()->lastname) > 15 ? '...' : ''}}
                              <b class="caret"></b>
                              <div class="ripple-container"></div>
                            </a>
                              <ul class="dropdown-menu dropdown-menu-right default-padding">
                                  <li class="dropdown-header"></li>

                                  <li>
                                      <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                          <i class="fa fa-sign-out"></i> &nbsp; {{Lang::get('architect::header.disconnect')}}
                                      </a>
                                      <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                                      {{csrf_field()}}
                                      </form>
                                  </li>
                              </ul>
                        </li>
                      </ul>
                    </div>

                  </div>

                </div>

              </div>
            </div>
        </div>

        {{-- BOTTOM NAV BAR --}}
        <!--
        <div class="topnav-bottom">
            <div class="container">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Inicio
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('medias.index')}}">
                            Medias
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        -->

    </div>
    <div class="clearfix"></div>
</header>
