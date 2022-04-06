<div wire:init="loadRecentlyReview">
    @forelse ($recentlyReviewGames as $game)
        <div class="game-card bg-gray-800 rounded-lg shadow-md p-8 flex flex-col md:flex-row mt-8">
            <div class="relative flex-none mx-auto h-full">
                <a href="{{ $game['url']}}">
                    <img src="{{ $game['cover'] }}" alt="game cover" class="w-48 hover:opacity-75 transition ease-in-out duration-200">
                </a>
                @if (isset($game['rating']))
                    <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-700 rounded-full -mr-5 -mb-5">
                        <div id="review-{{ $game['slug'] }}" class="font-semibold text-xs flex items-center justify-center h-full">
                            @push('scripts')
                                @include('_rating', [
                                    'slug' => 'review-' . $game['slug'],
                                    'rating' => $game['rating'],
                                ])
                            @endpush
                        </div>
                    </div>
                @endif
            </div>
            <div class="description mt-12 md:mt-0 md:ml-12 flex-grow">
                <a  class="block text-lg font-semibold leading-thight hover:text-gray-300 " href="{{ $game['url'] }}">
                    {{ $game['name'] }}
                </a>
                <p class="text-gray-400 mt-1">
                    {{ $game['platforms'] }}
                </p>
                <p class="mt-4  hidden lg:block  text-justify text-gray-400"> {{ $game['summary'] }}</p>
            </div>
        </div>
    @empty
        @foreach (range(1,3) as $review)
            <div class="game-card bg-gray-800 rounded-lg shadow-md p-8 flex flex-col md:flex-row mt-8">
                <div class="flex-none h-full">
                    <div class="bg-gray-700 w-40 h-56 inline-flex rounded-md shadow-sm items-center justify-center">
                        <svg class="animate-spin m-0 h-12 w-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
                <div class="description mt-12 md:mt-0 md:ml-12">
                    <div class="block text-lg text-transparent leading-thight bg-gray-700 rounded">
                        game title
                    </div>
                    <div class="inline-block  text-transparent bg-gray-700 mt-2 rounded">
                        platforms
                    </div>
                    <div class="mt-4 space-y-2 hidden lg:block">
                        @foreach (range(1, 4) as $summary)
                            <div class="bg-gray-700 text-transparent rounded"> Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

    @endforelse
</div>

@push('scripts')
    @include('_rating', [
        'event' => 'reviewGameRatingAdded',
    ]);
@endpush
