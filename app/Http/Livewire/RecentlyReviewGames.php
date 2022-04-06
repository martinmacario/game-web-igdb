<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


class RecentlyReviewGames extends Component
{
    public $recentlyReviewGames = [];

    public function loadRecentlyReview()
    {
        $before = Carbon:: now()->subMonths(2)->timestamp;
        $current = Carbon:: now()->timestamp;

        $unformatedGame = Cache::remember(
            'recently-review-games',
            7,
            function () use ($before, $current) {
                // sleep(3);
                // return Http::withHeaders(
                //         config('services.igdb')
                //     )->withOptions([
                //         'body' =>
                //             "fields name,
                //                 cover.url,
                //                 first_release_date,
                //                 popularity,
                //                 platforms.abbreviation,
                //                 rating,
                //                 rating_count,
                //                 summary,
                //                 slug;
                //             where platforms = (48, 49, 130, 6)
                //                 & (
                //                     first_release_date >= {$before}
                //                     & first_release_date < ${current}
                //                     & rating_count > 5
                //                 );
                //             sort rating desc;
                //             limit 3;
                //         "
                //     ])->get('https://api-v3.igdb.com/games/')->json();

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
                        summary,
                        slug ;
                    where platforms = (48, 49, 130, 6)
                        & total_rating_count > 5
                        & (
                            first_release_date >= {$before}
                            & first_release_date < ${current}
                            & rating_count > 5
                        );
                    sort total_rating_count desc;
                    limit 3;",
                    "text/plain"
                )->post('https://api.igdb.com/v4/games')
                ->json();
            }
        );

        $this->recentlyReviewGames = $this->formatGamesForView($unformatedGame);

        collect($this->recentlyReviewGames)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->emit(
                'reviewGameRatingAdded',[
                    'slug' => 'review-'.$game['slug'],
                    'rating' => $game['rating'],
                ]
            );
        });
    }

    private function formatGamesForView ($unformatedGame)
    {
        return collect($unformatedGame)->map(function ($game) {
            return collect($game)->merge([
                'url' => array_key_exists('slug', $game) ?
                    route('games.show', $game['slug']) : null,
                'cover' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
                'rating' => array_key_exists('rating', $game) ?
                    round($game['rating'])  : null,
                'platforms' => array_key_exists('platforms', $game) ?
                    collect($game['platforms'])->pluck('abbreviation')-> implode(', ') : null,
                'summary' => array_key_exists('summary', $game) ?
                    $game['summary'] : ''
                ]);
        })->toArray();
    }

    public function render()
    {
        return view('livewire.recently-review-games');
    }
}
