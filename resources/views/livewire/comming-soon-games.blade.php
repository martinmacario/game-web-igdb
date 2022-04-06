<div wire:init="loadCommingSoonGames" class="cooming-soon-container space-y-6">
    @forelse ($commingSoonGames as $game)
        <x-game-card-small :game="$game"/>
    @empty
        @foreach (range(1, 4) as $game)
            <x-game-card-skeleton-small/>
        @endforeach
    @endforelse
</div>
