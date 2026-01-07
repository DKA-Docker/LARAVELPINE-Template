<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-x-8 gap-y-6">
    <div class="col-span-1 md:col-span-2 mb-2">
        <h3 class="text-lg font-bold text-gray-900">Informasi Umum</h3>
    </div>

    {{-- Task Name --}}
    <div class="flex flex-col gap-1.5">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Tugas</span>
        <span class="text-sm font-bold text-gray-800">{{ $task['name'] ?? '-' }}</span>
    </div>

    {{-- Status --}}
    <div class="flex flex-col gap-1.5">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status Terkini</span>
        <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-600 text-xs font-bold w-fit uppercase">
            {{ str_replace('_', ' ', data_get(collect(data_get($task, 'history', []))->sortByDesc('created_at')->first(), 'to_status', 'Pending')) }}
        </span>
    </div>
    
    {{-- Request --}}
        <div class="flex flex-col gap-1.5">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Request Asal</span>
            <div class="flex items-center gap-2">
                 @if(isset($task['destination']['request']['account']['information']))
                    <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center text-primary text-[10px] font-bold">
                        {{ substr($task['destination']['request']['account']['information']['first_name'] ?? '-', 0, 1) }}
                    </div>
                    <span class="text-sm font-bold text-gray-800">
                        {{ $task['destination']['request']['account']['information']['first_name'] ?? '' }} {{ $task['destination']['request']['account']['information']['last_name'] ?? '' }}
                    </span>
                 @else
                    <span class="text-sm font-bold text-gray-500 italic">No Requester Linked</span>
                 @endif
            </div>
        </div>

     {{-- Vehicle --}}
     <div class="flex flex-col gap-1.5">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kendaraan</span>
        <div class="flex items-center gap-2 text-gray-800">
             <i class="ki-filled ki-car text-gray-400 fs-5"></i>
             <span class="text-sm font-bold">
                {{ $task['vehicle']['name'] ?? '-' }} <span class="text-gray-400 font-medium">({{ $task['vehicle']['plate'] ?? '-' }})</span>
             </span>
        </div>
    </div>
</div>
