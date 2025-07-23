<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">
        <a href="{{ isset($breadcrumbs[count($breadcrumbs)-1]->route) && Route::has($breadcrumbs[count($breadcrumbs)-1]->route.'.index') ? route($breadcrumbs[count($breadcrumbs)-1]->route.'.index'): 'javascript:;' }}">
            {{ $breadcrumbs[count($breadcrumbs)-1]->label ?? 'Dashboard' }}
        </a>
    </div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                @foreach($breadcrumbs->slice(0, -1) as $crumb)
                    <li class="breadcrumb-item active"><a href="{{ isset($crumb->route) && Route::has($crumb->route.'.index') ? route($crumb->route.'.index') : 'javascript:void(0);' }}">{{ $crumb->label }}</a></li>
                    @if (!$loop->last)
                        &nbsp; &raquo;
                @endif
                @endforeach
            </ol>
        </nav>
    </div>

    {{--<div class="ms-auto">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary">Settings</button>
            <button type="button" class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                <a class="dropdown-item" href="javascript:;">Another action</a>
                <a class="dropdown-item" href="javascript:;">Something else here</a>
                <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
            </div>
        </div>
    </div>--}}
</div>
<!--end breadcrumb-->
