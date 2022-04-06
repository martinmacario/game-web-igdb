<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class PopularGames extends Component
{
    public $popularGames = [];


    public function loadPopularGames()
    {
        $before = Carbon::now()->subMonths(2)->timestamp;
        $current = Carbon:: now()->timestamp;

        $unformatGames = Cache::remember(
            'popular-games',
            7,
            function () use ($before, $current) {

                return Http::withHeaders(
                    config('services.igdb')
                )->withBody(
                    "fields name,
                        cover.url,
                        first_release_date,
                        total_rating_count,
                        platforms.abbreviation,
                        rating,
                        rating_count,
                        slug ;
                    where platforms = (48, 49, 130, 6)
                        & total_rating_count > 5;
                    sort total_rating_count desc;
                    limit 12;",
                    "text/plain"
                )->post('https://api.igdb.com/v4/games')
                ->json();
        });

        $this->popularGames = $this->formatGamesForView($unformatGames);

        collect($this->popularGames)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->emit(
                'popularGameRatingAdded',[
                    'slug' => $game['slug'],
                    'rating' => $game['rating'],
                ]
            );
        });
    }

    public function render()
    {
        return view('livewire.popular-games');
    }

    private function formatGamesForView ($games)
    {
        return collect($games)->map( function ($game) {
            return collect($game)->merge([
                'url' => route('games.show', $game['slug']),
                'cover' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
                'rating' => array_key_exists('rating', $game) ?
                    round($game['rating']) : null,
                'platforms' => array_key_exists('platforms', $game) ?
                    implode(', ', array_column($game['platforms'], 'abbreviation')) : null,
            ]);
        })->toArray();
    }
}
