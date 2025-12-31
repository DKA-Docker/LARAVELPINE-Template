<div class="flex flex-col grow pt-5" id="scrollable_content">
    <main class="grow" role="content">
        <!-- Toolbar -->
        <div class="pb-6">
            <!-- Container -->
            <div class="kt-container-fluid flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center flex-wrap gap-1 lg:gap-5">
                    <h1 class="font-medium text-lg text-mono">
                        Delivery Reports
                    </h1>
                    <div class="flex items-center gap-1 text-sm font-normal">
                        <a class="text-secondary-foreground hover:text-primary" href="#">
                            Home
                        </a>
                        <span class="text-muted-foreground text-sm">
                            /
                        </span>
                        <span class="text-secondary-foreground">
                            Apps
                        </span>
                        <span class="text-muted-foreground text-sm">
                            /
                        </span>
                        <span class="text-mono">
                            Reports
                        </span>
                    </div>
                </div>
            </div>
            <!-- End of Container -->
        </div>
        <!-- End of Toolbar -->
        <!-- Container -->
        <div class="kt-container-fluid">
            <div class="flex flex-col items-stretch gap-7">
                <div class="flex items-center gap-3 w-full">
                    <div class="kt-input w-full">
                        <i class="ki-filled ki-magnifier">
                        </i>
                        <input wire:model.live.debounce.300ms="query" placeholder="Search Reports" type="text" />
                    </div>
                    <!--Filter-->
                    <button class="kt-dropdown-toggle kt-btn kt-btn-primary">
                        <i class="ki-filled ki-filter">
                        </i>
                        Filter
                    </button>
                    <!--End of Filter-->
                </div>
                
                <!-- Date Filters -->
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2">
                        <input type="date" wire:model.live="startDate" class="h-10 px-3 py-2 rounded-md border border-input bg-background text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        <span class="text-muted-foreground">-</span>
                        <input type="date" wire:model.live="endDate" class="h-10 px-3 py-2 rounded-md border border-input bg-background text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="kt-btn kt-btn-sm kt-btn-outline {{ $dateFilter === 'this_month' ? 'bg-primary text-primary-foreground' : '' }}" wire:click="setDateFilter('this_month')">
                            Month
                        </button>
                        <button class="kt-btn kt-btn-sm kt-btn-outline {{ $dateFilter === 'last_6_months' ? 'bg-primary text-primary-foreground' : '' }}" wire:click="setDateFilter('last_6_months')">
                            6 Months
                        </button>
                        <button class="kt-btn kt-btn-sm kt-btn-outline {{ $dateFilter === 'this_year' ? 'bg-primary text-primary-foreground' : '' }}" wire:click="setDateFilter('this_year')">
                            Year
                        </button>
                         <button class="kt-btn kt-btn-sm kt-btn-outline {{ $dateFilter === 'all' ? 'bg-primary text-primary-foreground' : '' }}" wire:click="setDateFilter('all')">
                            All
                        </button>
                    </div>
                <!-- begin: toolbar -->
                <div class="flex flex-wrap items-center gap-5 justify-between mt-3">
                    <h3 class="text-sm text-mono font-medium">
                        Showing {{ $reports->firstItem() }} - {{ $reports->lastItem() }} of {{ $reports->total() }} results
                    </h3>
                    <div class="flex items-center gap-2.5">
                        <button class="kt-btn kt-btn-sm kt-btn-light" wire:click="exportPdf">
                            <i class="ki-filled ki-file-down"></i>
                            Export PDF
                        </button>
                        <select class="kt-select w-[175px] bg-background" data-kt-select="true" name="kt-select">
                            <option selected="" value="1">
                                Newest First
                            </option>
                            <option value="2">
                                Oldest First
                            </option>
                        </select>
                    </div>
                </div>
                <!-- end: toolbar -->

                <!-- begin: list -->
                <div class="" id="shop1_lists">
                     <!-- Skeleton Loading -->
                    <div wire:loading class="grid grid-cols-1 gap-5 w-full">
                        @for($i = 0; $i < 5; $i++)
                            <div class="kt-card animate-pulse">
                                <div class="kt-card-content flex items-center flex-wrap justify-between p-2 pe-5 gap-4.5">
                                    <div class="flex items-center gap-3.5 w-2/3">
                                        <div class="bg-gray-200 rounded h-[70px] w-[90px] shadow-none"></div>
                                        <div class="flex flex-col gap-2 w-full">
                                            <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                                            <div class="flex items-center gap-2">
                                                <div class="h-5 bg-gray-200 rounded-full w-20"></div>
                                                <div class="h-3 bg-gray-200 rounded w-1/4"></div>
                                                <div class="h-3 bg-gray-200 rounded w-1/4"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <div class="flex -space-x-2">
                                            <div class="h-8 w-8 bg-gray-200 rounded-full ring-2 ring-white"></div>
                                            <div class="h-8 w-8 bg-gray-200 rounded-full ring-2 ring-white"></div>
                                        </div>
                                        <div class="h-9 w-24 bg-gray-200 rounded ms-2"></div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <!-- begin: grid -->
                    <div wire:loading.remove class="grid grid-cols-1 gap-5">
                        @forelse($reports as $report)
                            <div class="kt-card">
                                <div class="kt-card-content flex items-center flex-wrap justify-between p-2 pe-5 gap-4.5">
                                    <div class="flex items-center gap-3.5">
                                        <div class="kt-card flex items-center justify-center bg-accent/50 h-[70px] w-[90px] shadow-none">
                                            <div class="flex -space-x-2">
                                        @php
                                            $drivers = collect();
                                            foreach($report->assigns as $assign) {
                                                if($assign->assignedAccount) {
                                                    $drivers->push($assign->assignedAccount);
                                                }
                                            }
                                            $drivers = $drivers->unique('id');
                                        @endphp
                                        @foreach($drivers as $user)
                                            @php
                                                $firstName = $user->information->first_name ?? '';
                                                $lastName = $user->information->last_name ?? '';
                                                $fullName = trim($firstName . ' ' . $lastName);
                                                if (empty($fullName)) {
                                                    $fullName = $user->credential->username ?? $user->name ?? 'Driver';
                                                }
                                            @endphp
                                            <div class="flex" title="{{ $fullName }}">
                                                <img class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                     src="{{ $user->avatar_url ?? asset('storage/avatars/300-1.png') }}"
                                                     alt="{{ $fullName }}" />
                                            </div>
                                        @endforeach
                                    </div>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <div class="flex items-center gap-2.5 -mt-1">
                                                <a class="hover:text-primary text-sm font-medium text-mono leading-5.5" href="#">
                                                    {{ $report->name ?? 'Task #' . $report->id }}
                                                </a>
                                            </div>
                                            <div class="flex items-center flex-wrap gap-3">
                                                <span class="kt-badge kt-badge-warning kt-badge-sm rounded-full gap-1">
                                                    {{ $report->history->sortByDesc('created_at')->first()->to_status ?? 'Pending' }}
                                                </span>
                                                <div class="flex items-center flex-wrap gap-2 lg:gap-4">
                                                    <span class="text-xs font-normal text-secondary-foreground uppercase">
                                                        ID:
                                                        <span class="text-xs font-medium text-foreground">
                                                            {{ substr($report->id, 0, 8) }}
                                                        </span>
                                                    </span>
                                                    <span class="text-xs font-normal text-secondary-foreground">
                                                        Destination:
                                                        <span class="text-xs font-medium text-foreground">
                                                            {{ $report->destinationData->receipt_name ?? 'N/A' }}
                                                        </span>
                                                    </span>
                                                    @php $pkgCount = $report->destinationData->packages->count() ?? 0; @endphp
                                                    <div class="flex items-center gap-2.5 p-1.5 pr-4 rounded-xl bg-primary/5 w-fit">
                                                        <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-white shadow-sm text-primary">
                                                            <i class="ki-duotone ki-delivery-3 fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                        </div>
                                                        <div class="flex flex-col leading-none">
                                                            <span class="text-[12px] font-black text-primary">{{ $pkgCount }}</span>
                                                            <span class="text-[8px] font-bold text-primary/60 uppercase">Paket</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <div class="flex -space-x-2 overflow-hidden">
                                            @foreach($report->assigned as $user)
                                                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" alt="{{ $user->name }}"/>
                                            @endforeach
                                        </div>
                                        <button class="kt-btn kt-btn-outline ms-2 shrink-0">
                                            <i class="ki-filled ki-eye">
                                            </i>
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-10">
                                <span class="text-muted-foreground">No reports found.</span>
                            </div>
                        @endforelse
                    </div>
                </div>
                <!-- end: list -->
                
                <div class="mt-5">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </main>
</div>
