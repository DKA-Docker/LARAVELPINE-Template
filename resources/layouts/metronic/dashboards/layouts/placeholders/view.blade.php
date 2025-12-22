<div class="kt-container-fixed animate-pulse">
    <div class="grid gap-5 lg:gap-7.5">

        {{-- SKELETON FILTER --}}
        <div class="rounded-2xl bg-white border border-gray-100 px-6 py-4 flex flex-wrap items-center gap-4 shadow-sm">
            <div class="h-9 w-44 bg-gray-200 rounded-xl"></div>
            <div class="flex flex-wrap gap-2 items-center">
                <div class="h-9 w-40 bg-gray-100 rounded-xl"></div>
                <div class="h-9 w-36 bg-gray-100 rounded-xl"></div>
                <div class="h-9 w-28 bg-gray-100 rounded-xl"></div>
            </div>
        </div>

        {{-- SKELETON TABLE CARD --}}
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
            {{-- Header --}}
            <div class="px-8 py-5 border-b border-gray-50">
                <div class="h-4 w-40 bg-gray-200 rounded mb-2"></div>
                <div class="h-3 w-24 bg-gray-100 rounded"></div>
            </div>

            <div class="px-2">
                <div class="overflow-x-auto">
                    <table class="w-full align-middle">
                        <thead>
                        <tr class="border-b border-gray-50">
                            <th class="px-6 py-5"><div class="h-3 w-20 bg-gray-100 rounded"></div></th>
                            <th class="px-6 py-5"><div class="h-3 w-24 bg-gray-100 rounded"></div></th>
                            <th class="px-6 py-5"><div class="h-3 w-24 bg-gray-100 rounded"></div></th>
                            <th class="px-6 py-5"><div class="h-3 w-16 bg-gray-100 rounded"></div></th>
                            <th class="px-6 py-5 text-right"><div class="h-3 w-16 bg-gray-100 rounded ml-auto"></div></th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- Loop 5 baris skeleton --}}
                        @foreach(range(1, 5) as $index)
                            <tr class="border-b border-gray-50 last:border-0">
                                {{-- Request Name --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-gray-100 shrink-0"></div>
                                        <div class="space-y-2">
                                            <div class="h-4 w-32 bg-gray-200 rounded"></div>
                                            <div class="h-3 w-20 bg-gray-100 rounded"></div>
                                        </div>
                                    </div>
                                </td>
                                {{-- Muatan --}}
                                <td class="px-6 py-5">
                                    <div class="flex gap-2">
                                        <div class="h-10 w-12 bg-gray-100 rounded-lg"></div>
                                        <div class="h-10 w-12 bg-gray-100 rounded-lg"></div>
                                    </div>
                                </td>
                                {{-- Requested By --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-gray-100"></div>
                                        <div class="space-y-2">
                                            <div class="h-3 w-24 bg-gray-200 rounded"></div>
                                            <div class="h-2 w-32 bg-gray-100 rounded"></div>
                                        </div>
                                    </div>
                                </td>
                                {{-- Status --}}
                                <td class="px-6 py-5">
                                    <div class="h-6 w-20 bg-gray-100 rounded-full"></div>
                                </td>
                                {{-- Created At --}}
                                <td class="px-6 py-5 text-right">
                                    <div class="space-y-2">
                                        <div class="h-3 w-16 bg-gray-200 rounded ml-auto"></div>
                                        <div class="h-2 w-10 bg-gray-100 rounded ml-auto"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-8 py-5 bg-gray-50/50 flex justify-between items-center">
                <div class="h-4 w-32 bg-gray-200 rounded"></div>
                <div class="h-8 w-48 bg-gray-200 rounded-lg"></div>
            </div>
        </div>
    </div>
</div>
