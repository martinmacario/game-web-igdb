<div class="game flex">
    <a href="{{ $game['url'] }}">
        <img src="{{ $game['cover'] }}" alt="game cover" class="w-16 hover:opacity-75 transition ease-in-out duration-200">
    </a>
    <div class="ml-4">
        <a href="{{ $game['url'] }}" class="hover:text-gray-300">
            {{ $game['name'] }}
        </a>
        <div class="text-sm mt-1 text-gray-400">
            {{ $game['releaseDate'] }}
        </div>
    </div>
</div>
