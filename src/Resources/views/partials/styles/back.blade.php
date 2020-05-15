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

@php
  $primaryColor = isset($storedStylesBack['backPrimary']) ? $storedStylesBack['backPrimary']->value :'#2A3649';
  $secondaryColor= isset($storedStylesBack['backSecondary']) ? $storedStylesBack['backSecondary']->value  :'#146dbb';

  $headerTextColor= isset($storedStylesBack['backHeaderTextColor']) ? $storedStylesBack['backHeaderTextColor']->value  :'#fff';
  $headerBackgroundColor= isset($storedStylesBack['backHeaderBackgroundColor']) ? $storedStylesBack['backHeaderBackgroundColor']->value  :'#273544';
  $headerRightPartBackgroundHoverColor= isset($storedStylesBack['backHeaderRightPartBackgroundHoverColor']) ? $storedStylesBack['backHeaderRightPartBackgroundHoverColor']->value  :$primaryColor;
  $headerLogoBackgroundColor= isset($storedStylesBack['backHeaderLogoBackgroundColor']) ? $storedStylesBack['backHeaderLogoBackgroundColor']->value  :'#fff';

  /*SIDEBAR*/
  $sidebarBackgroundColor = isset($storedStylesBack['backSidebarBackgroundColor']) ? $storedStylesBack['backSidebarBackgroundColor']->value  : '#dadada';
  $sidebarBackgroundColorHover = isset($storedStylesBack['backSidebarBackgroundColorHover']) ? $storedStylesBack['backSidebarBackgroundColorHover']->value  : '#bcbcbc';
  $sidebarColor = isset($storedStylesBack['backSidebarColor']) ? $storedStylesBack['backSidebarColor']->value  :'#455660';
  $sidebarHoverColor = isset($storedStylesBack['backSidebarHoverColor']) ? $storedStylesBack['backSidebarHoverColor']->value  :'#273544';
  $sidebarHoverIconBorderColor = isset($storedStylesBack['backSidebarHoverIconBorderColor']) ? $storedStylesBack['backSidebarHoverIconBorderColor']->value  :$primaryColor;//$primaryColor

  /*BUTTONS*/
  $backPrimaryButtonBackgroundColor = isset($storedStylesBack['backPrimaryButtonBackgroundColor']) ? $storedStylesBack['backPrimaryButtonBackgroundColor']->value  : '#4a9fea';
  $backPrimaryTextColor = isset($storedStylesBack['backPrimaryTextColor']) ? $storedStylesBack['backPrimaryTextColor']->value  : '#fff';
  $backSecondaryButtonBackgroundColor = isset($storedStylesBack['backSecondaryButtonBackgroundColor']) ? $storedStylesBack['backSecondaryButtonBackgroundColor']->value  : '#fff';
  $backSecondaryTextColor = isset($storedStylesBack['backSecondaryTextColor']) ? $storedStylesBack['backSecondaryTextColor']->value  : '#455660';

@endphp

<style type="text/css">

  /*header */
  #main header .topnav .topnav-top {
    background-color: {{$headerBackgroundColor}};
    color: {{$headerTextColor}};
  }

  #main header .topbar-right {
    background-color:{{$headerBackgroundColor}};
  }

  #main header .topbar-right .navbar-nav > li > .dropdown-menu {
    background-color : {{$headerRightPartBackgroundHoverColor}} !important;
  }
  #main header .topbar-right .navbar-nav > li > .dropdown-menu a{
    color: {{$headerTextColor}};
  }
  #main header .topbar-right .navbar-nav > li > .dropdown-menu a i{
    color: {{$headerTextColor}};
  }
  #main header .topbar-right .navbar-nav > li > .dropdown-menu a:hover{
    color: {{$primaryColor}} !important;
  }


  #main header .topbar-right .nav li a{
    color: {{$headerTextColor}};
  }

  #main header .topbar-right .navbar-collapse .nav a:hover, #main header .topbar-right .navbar-collapse .nav a:active, #main header .topbar-right .navbar-collapse .nav a:focus{
    background-color: {{$headerRightPartBackgroundHoverColor}} !important;
    color: {{$headerTextColor}} !important;
  }

  #main header .topbar-right .navbar-collapse .dropdown.open a.dropdown-toggle {
    background-color:{{$headerRightPartBackgroundHoverColor}} !important;
    color: {{$headerTextColor}};
  }


  #main header #logo-wrapper{
    background-color:{{$headerLogoBackgroundColor}};
  }

  #main header nav.main-nav ul li a{
    color:{{$headerTextColor}};
  }
  #main header nav.main-nav ul li a:hover{
    color: {{$primaryColor}};
    border-bottom: 3px solid {{$primaryColor}};
  }

  #main header nav.main-nav ul li.active a{
    color: {{$primaryColor}};
    border-bottom: 3px solid {{$primaryColor}};
  }

  body{
    color: {{$secondaryColor}};
  }


  .leftbar-page .sidebar {
    background-color: {{$sidebarBackgroundColor}};
  }

  .leftbar-page .sidebar ul li a{
    color:{{$sidebarColor}};
  }

  .leftbar-page .sidebar ul li:hover a, .leftbar-page .sidebar ul li.active a {
    background-color: {{$sidebarBackgroundColorHover}};
    border-left: 3px solid {{$sidebarHoverIconBorderColor}};
    color:{{$sidebarHoverColor}};
  }

  .leftbar-page .sidebar ul li:hover a i {
    color: {{$sidebarHoverIconBorderColor}};
  }

  #app .btn.btn-primary{
    background-color: {{$backPrimaryButtonBackgroundColor}};
    color:{{$backPrimaryTextColor}};
  }

  #app .btn.btn-default{
    background-color: {{$backSecondaryButtonBackgroundColor}};
    color:{{$backSecondaryTextColor}};
  }

</style>
