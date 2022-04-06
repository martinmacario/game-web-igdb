<div class="relative" x-data="{ isVisible: true }" @click.away="isVisible = false">
    <input  type="text" 
        wire:model.debounce.1000ms='search'
        class="pl-8 rounded-full w-64 px-4 py-1 focus:outline-none focus:shadow-outline bg-gray-800 text-sm" 
        placeholder="Search (Type '/' to focus)" 
        name=""
        wire:model="search"
        x-ref="search"
        @focus="isVisible = true"
        @keydown.escape.window="isVisible = false"
        @keydown="isVisible = true"
        @keydown.shift.tab="isVisible = false"
        @keydown.window="
            if (event.keyCode === 191)
            {
                event.preventDefault();
                $refs.search.focus();
            }
        "

        >
    <div class="absolute top-0 flex items-center h-full ml-2">
        <svg viewBox="0 0 20 20" 
        fill="currentColor" 
        class="search w-4"><path fill-rule="evenodd" 
        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" 
        clip-rule="evenodd"/></svg>
    </div>
    <div wire:loading class="absolute right-0 flex items-center h-full mr-2 mt-2">
        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
    @if (strlen($search) >= 2)
        <div class="mt-2 results absolute z-50 w-full rounded bg-gray-700 overflow-hidden" x-show.transition.opacity.duration.1000="isVisible">
            @if (count($searchResult) > 0)
                <ul>
                    @foreach ($searchResult as $game)
                    <li>
                        <a 
                            class="flex items-center px-3 py-2 border-b border-gray-500 hover:bg-gray-600 transition ease-in-out duration-1000 h-20"
                            href="{{ $game['url'] }}"
                            @if ($loop->last)
                                @keydown.tab="isVisible = false"
                            @endif

                            >
                        <img class="w-10" src="{{ $game['cover'] }}" alt="">
                        <span class="ml-4">{{ $game['name'] }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
            @else
                <div class="rounded p-3">
                    No results found for "{{ $search }}"
                </div>
            @endif
        </div>
    @endif
</div>