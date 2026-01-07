<div class="card card-flush shadow-sm">
    <div class="card-header">
        <div class="h-8 bg-gray-200 rounded w-1/4 my-auto"></div>
    </div>
    <div class="card-body">
        <div class="flex flex-col gap-4">
            {{-- List Items --}}
            @foreach(range(1, 3) as $i)
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gray-200"></div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                        <div class="h-3 bg-gray-200 rounded w-1/4"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
