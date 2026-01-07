<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between mb-2">
        <h3 class="text-lg font-bold text-gray-900">Tim Tertugas</h3>
        <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-600 text-xs font-bold">
            {{ count(data_get($task, 'assigned', [])) }} Orang
        </span>
    </div>

    @if(empty(data_get($task, 'assigned', [])))
        <div class="flex flex-col items-center justify-center py-10 border-2 border-dashed border-gray-200 rounded-xl text-gray-400">
            <i class="ki-outline ki-profile-user text-3xl mb-2 opacity-50"></i>
            <span class="text-xs font-bold uppercase tracking-wide">Belum ada user yang ditugaskan</span>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach(data_get($task, 'assigned', []) as $user)
                <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl hover:border-primary/50 hover:shadow-sm transition-all bg-white">
                    {{-- Avatar --}}
                    <div class="relative w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden shrink-0">
                        @if(data_get($user, 'avatar'))
                            <img src="{{ data_get($user, 'avatar') }}" class="w-full h-full object-cover" alt="{{ data_get($user, 'information.first_name', 'Avg') }}">
                        @else
                            <span class="text-primary font-bold text-lg">
                                {{ substr(data_get($user, 'information.first_name', 'U'), 0, 1) }}
                            </span>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-gray-800 font-bold text-sm truncate" title="{{ data_get($user, 'information.first_name', '') }} {{ data_get($user, 'information.last_name', '') }}">
                            {{ data_get($user, 'information.first_name', '') }} {{ data_get($user, 'information.last_name', '') }}
                        </span>
                         <span class="text-gray-400 font-bold text-[10px] uppercase truncate">
                            {{ data_get($user, 'contact.email', data_get($user, 'credential.username', 'No Email')) }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
