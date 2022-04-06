<div class="game m-auto sm:m-0">
    <div class="relative inline-block">
        <a href="{{ $game['url'] }}">
            <img src="{{ $game['cover'] }}" alt="game cover" class="hover:opacity-75 transition ease-in-out duration-200">
        </a>
        @if (isset($game['rating']))
            <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full -mr-5 -mb-5">
                <div id="{{ $game['slug'] }}" class="font-semibold text-xs flex items-center justify-center h-full">
                    @push('scripts')
                        @include('_rating', [
                            'slug' => $game['slug'],
                            'rating' => $game['rating'],
                        ])
                    @endpush
                </div>
            </div>
        @endif
    </div>
    <a class="block text-base font-semibold leading-thight hover:text-gray-500 mt-4 " href="#">{{$game['name']}}</a>
    <div class="text-gray-400 mt-1">
        {{ $game['platforms'] }}
    </div>
</div>
