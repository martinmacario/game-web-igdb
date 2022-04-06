<div wire:init="loadPopularGames" class="popular-games text-sm grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-12 border-b border-gray-800 pt-4 pb-4">
    @forelse ($popularGames as $game)
        <x-game-card :game="$game" />
    @empty
        @foreach (range(1, 12) as $game)
            <div class="game m-auto">
                <div class="bg-gray-800 w-44 h-56 relative inline-flex rounded-md shadow-sm items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <div class="block text-transparent text-lg leading-thight bg-gray-700 mt-4 rounded">Game title</div>
                <div class="inline-block text-transparent bg-gray-700 mt-2 rounded">Platforms</div>
            </div>
        @endforeach
    @endforelse
</div><!-- popular games -->
@push('scripts')
    @include('_rating', [
        'event' => 'popularGameRatingAdded',
    ]);
    {{-- <script>
        window.livewire.on('popularGameRatingAdded', params => {
            console.log(`A post was added with the id of: ${gameId}, ${rating}`);
        });
    </script> --}}
@endpush


