<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class CommingSoonGames extends Component
{
    public $commingSoonGames = [];
    public function loadCommingSoonGames()
    {
        $before = Carbon:: now()->subMonths(2)->timestamp;
        $after = Carbon:: now()->addMonths(2)->timestamp;
        $afterFourMonths = Carbon:: now()->addMonths(4)->timestamp;
        $current = Carbon:: now()->timestamp;

        $unformatedGames = Cache::remember(
            'comming-soon-games',
            7,
            function () use ($current) {
                // sleep(3);
                // return Http::withHeaders(
                //     config('services.igdb')
                // )->withOptions([
                //     'body' => "
                //         fields name,
                //             cover.url,
                //             first_release_date,
                //             popularity,
                //             platforms.abbreviation,
                //             rating,
                //             slug ;
                //         where platforms = (48, 49, 130, 6)
                //             & (first_release_date >= {$current} & popularity > 5);
                //         sort first_release_date asc;
                //         limit 4;"
                // ])->get('https://api-v3.igdb.com/games/')->json();

                return Http::withHeaders(
                    config('services.igdb')
                )->withBody(
                    "fields name,
                        cover.url,
                        first_release_date,
                        total_rating_count,
                        platforms.abbreviation,
                        rating,
                        slug ;
                    where platforms = (48, 49, 130, 6)
                        & (first_release_date >= {$current}) ;
                    sort first_release_date asc;
                    limit 4;",
                    "text/plain"
                )->post('https://api.igdb.com/v4/games')
                ->json();
            }
        );

        $this->commingSoonGames = $this->formatGamesForView($unformatedGames);


    }

    public function render()
    {
        return view('livewire.comming-soon-games');
    }

    private function formatGamesForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'url' => isset($game['slug']) ? route('games.show', $game['slug']) : null,
                'cover' => isset($game['cover']) ? Str::replaceFirst('thumb', 'cover_small', $game['cover']['url']) : null,
                'releaseDate' => isset($game['first_release_date']) ? Carbon::parse($game['first_release_date'])->format('M d, Y') : null,
                'name' => isset($game['name']) ? $game['name'] : null,
            ]);
        })->toArray();

    }
}
