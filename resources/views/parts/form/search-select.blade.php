<div class="relative group w-[400px] max-sm:w-full" x-data="{ open: false }">
    <button @if(isset($disabled) && $disabled === true) disabled @endif type="button" x-on:click="open = !open" id="dropdown-button" class="inline-flex justify-center items-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
        <span title="{{ $selected }}" class="line-clamp-1">{{ $selected }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 min-w-5 -mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>
    <div id="dropdown-menu" x-bind:class="! open ? 'hidden' : ''" class="w-full absolute right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1 {{ $zIndex }} overflow-y-auto max-h-[400px] pt-0">
        <!-- Search input -->
        <div class="sticky top-0 left-0 right-0 w-full">
            <input id="search-input" wire:model.live.debounce.250ms="{{ $search }}" class="block w-full px-4 py-2 text-gray-800 border rounded-md  border-gray-300 focus:outline-none" type="text" placeholder="Search items" autocomplete="off">
        </div>
        @foreach($options as $option)
            <div href="#" wire:click="{{ $select }}('{{ $option->$value }}')" x-on:click="open = ! open" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md">{{ $option->$name }}</div>
        @endforeach
    </div>
    @if(isset($model))
        @error($model)
        <div class="label">
            <span class="label-text-alt text-red-500">{{ $message }}</span>
        </div>
        @enderror
    @endif
</div>

{{--<div class="relative group" x-data="{ open: false }">--}}
{{--    <button type="button" x-on:click="open = ! open" id="dropdown-button" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">--}}
{{--        <span class="mr-2">Open Dropdown</span>--}}
{{--        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
{{--            <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />--}}
{{--        </svg>--}}
{{--    </button>--}}
{{--    <div id="dropdown-menu" x-bind:class="! open ? 'hidden' : ''" class="w-full absolute right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1">--}}
{{--        <!-- Search input -->--}}
{{--        <input id="search-input" wire:model.live.debounce.250ms="searchCity" class="block w-full px-4 py-2 text-gray-800 border rounded-md  border-gray-300 focus:outline-none" type="text" placeholder="Search items" autocomplete="off">--}}
{{--        @foreach($cities as $city)--}}
{{--            <div href="#" wire:click="selectCity('{{ $city->id }}')" x-on:click="open = ! open" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md">{{ $city->name }}</div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--</div>--}}
