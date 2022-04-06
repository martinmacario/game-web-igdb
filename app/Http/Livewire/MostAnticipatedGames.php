<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;



class MostAnticipatedGames extends Component
{
    public $mostAnticipatedGames = [];

    public function loadMostAnticipatedGames()
    {
        $afterFourMonths = Carbon:: now()->addMonths(4)->timestamp;
        $current = Carbon:: now()->timestamp;


        $unformatedGames = Cache::remember(
            'most-anticipated-games',
            7,
            function () use ($current, $afterFourMonths) {
                // sleep(3);
                // return Http::withHeaders(
                //     config('services.igdb')
                // )->withOptions([
                //     'body' =>
                //         "fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, slug ;
                //         where platforms = (48, 49, 130, 6) & (first_release_date >= {$current} & first_release_date < ${afterFourMonths});
                //         sort popularity desc;
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
                        slug;
                    where platforms = (48, 49, 130, 6)
                        & (
                            first_release_date >= {$current}
                            & first_release_date < ${afterFourMonths}
                        );
                        sort total_rating_count desc;
                        limit 4;",
                    "text/plain"
                )->post('https://api.igdb.com/v4/games')
                ->json();
            }
        );

        $this->mostAnticipatedGames = $this->formatGamesForView($unformatedGames);
    }

    public function render()
    {
        return view('livewire.most-anticipated-games');
    }

    private function formatGamesForView ($games)
    {
        // dd($games);
        return collect($games)->map( function ($game) {
            return collect($game)->merge([
                'url' => route('games.show', $game['slug']),
                'cover' => isset($game['cover']) ? Str::replaceFirst('thumb', 'cover_small', $game['cover']['url']) : null,
                'releaseDate' => Carbon::parse($game['first_release_date'])->format('M d, Y'),
            ]);
        })->toArray();
    }

}
