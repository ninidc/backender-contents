@if(config('backender:contents::menu'))
@foreach(config('backender:contents::menu') as $item)

    {{-- If current user can show this menu --}}
    @if(!empty($item['permissions'])) 
        @HasNotAbilities($item['permissions'])
            @continue;
        @endHasNotAbilities
    @endif 

    {{-- Request pattern for display active of not the menu item --}}
    @if(!empty($item['patterns']))
        @php
            $isActive = collect($item['patterns'])->filter(function($pattern){
                return Request::is($pattern) ? true : false;
            })->first();
        @endphp
    @endif

    {{-- Render the menu item --}}
    <li class="{{ $isActive ? 'active' : false }}">
        <a href="{{ route($item['route']) }}">
            {{ Lang::get($item['label']) }}
        </a>
    </li>

@endforeach()
@endif
