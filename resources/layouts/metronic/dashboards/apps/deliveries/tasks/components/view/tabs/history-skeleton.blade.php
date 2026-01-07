<div class="card card-flush shadow-sm">
    <div class="card-header">
        <div class="h-8 bg-gray-200 rounded w-1/4 my-auto"></div>
    </div>
    <div class="card-body">
         <div class="space-y-6">
            @foreach(range(1, 4) as $i)
                <div class="flex gap-4">
                    <div class="w-2 h-full bg-gray-100 rounded-full mx-2"></div>
                    <div class="flex flex-col gap-2 w-full">
                         <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                         <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                    </div>
                </div>
            @endforeach
         </div>
    </div>
</div>
