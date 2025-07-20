<!--start sidebar-->
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="{{ asset('/storage/images/logo-icon.png') }}" class="logo-img" alt="">
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0">{{ env('APP_NAME', 'Laravel') }}</h5>
        </div>
        <div class="sidebar-close">
            <span class="material-icons-outlined">close</span>
        </div>
    </div>
    <div class="sidebar-nav">
        <!--navigation-->
        <ul class="metismenu" id="sidenav">

            @foreach ($sections as $section)
                {{-- Heading --}}
                <li class="menu-label">{{ $section->heading }}</li>

                {{-- Parent menu --}}
                @foreach ($section->items as $menuItem)
                    <li class="menu-item">
                        <a href="{{ isset($menuItem->routes) && Route::has($menuItem->routes) ? route($menuItem->routes) : 'javascript:void(0);' }}"
                           data-href="{{ isset($menuItem->routes) && Route::has($menuItem->routes) ? route($menuItem->routes) : '' }}"
                           class="{{ $menuItem->children->isNotEmpty() ? 'has-arrow' : '' }}">
                            <div class="parent-icon">
                                <i class="material-icons-outlined">{{ $menuItem->icon }}</i>
                            </div>
                            <div class="menu-title">{{ $menuItem->name }}</div>
                        </a>

                        {{-- Anak-anak menu --}}
                        @if ($menuItem->children->isNotEmpty())
                            <ul>
                                @foreach ($menuItem->children as $child)
                                    <li>
                                        <a href="{{ isset($child->routes) && Route::has($child->routes) ? route($child->routes) : 'javascript:void(0);' }}"
                                           data-href="{{ isset($child->routes) && Route::has($child->routes) ? route($child->routes) : '' }}">
                                            <i class="material-icons-outlined">{{ $child->icon }}</i>
                                            {{ $child->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            @endforeach

        </ul>
        <!--end navigation-->
    </div>
</aside>
<!--end sidebar-->
