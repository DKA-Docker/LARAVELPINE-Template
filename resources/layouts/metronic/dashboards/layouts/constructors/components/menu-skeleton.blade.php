<div class="kt-menu flex grow flex-col gap-1 animate-pulse" id="sidebar_menu">

    {{-- SKELETON: Overview --}}
    <div class="kt-menu-item">
        <div class="flex items-center gap-[10px] ps-[10px] pe-[10px] py-[6px]">
            <div class="w-[20px] h-[20px] bg-gray-200 rounded"></div>
            <div class="h-4 w-24 bg-gray-200 rounded"></div>
        </div>
    </div>

    {{-- SKELETON: Heading Apps --}}
    <div class="kt-menu-item pt-2.25 pb-px">
        <div class="ms-[10px] h-3 w-12 bg-gray-100 rounded mb-1"></div>
    </div>

    {{-- SKELETON: Accordion Item (Delivery) --}}
    <div class="kt-menu-item">
        <div class="flex items-center gap-[10px] py-[6px] ps-[10px] pe-[10px]">
            <div class="w-[20px] h-[20px] bg-gray-200 rounded"></div>
            <div class="h-4 w-28 bg-gray-200 rounded"></div>
            <div class="ms-auto w-3 h-3 bg-gray-100 rounded"></div>
        </div>

        {{-- SKELETON: Sub-menu Items --}}
        <div class="ps-[10px] mt-1 space-y-1">
            @foreach(range(1, 3) as $i)
                <div class="flex items-center gap-[14px] py-[8px] ps-[26px]">
                    <div class="w-[20px] h-[20px] bg-gray-100 rounded"></div>
                    <div class="h-3 w-20 bg-gray-100 rounded"></div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- SKELETON: Tracking --}}
    <div class="kt-menu-item">
        <div class="flex items-center gap-[10px] ps-[10px] pe-[10px] py-[6px]">
            <div class="w-[20px] h-[20px] bg-gray-200 rounded"></div>
            <div class="h-4 w-24 bg-gray-200 rounded"></div>
        </div>
    </div>

    {{-- SKELETON: Heading Management --}}
    <div class="kt-menu-item pt-2.25 pb-px">
        <div class="ms-[10px] h-3 w-20 bg-gray-100 rounded mb-1"></div>
    </div>

    {{-- SKELETON: Account --}}
    <div class="kt-menu-item">
        <div class="flex items-center gap-[10px] ps-[10px] pe-[10px] py-[6px]">
            <div class="w-[20px] h-[20px] bg-gray-200 rounded"></div>
            <div class="h-4 w-24 bg-gray-200 rounded"></div>
        </div>
    </div>

</div>
