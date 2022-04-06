<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


class GamesController extends Controller
{
    public function test()
    {

        
        $askGames1 = Http::withHeaders(
            config('services.igdb')
            )->withOptions([
                'body' =>'
                    fields name, slug, cover.url;
                    where name ~ "port"*;
                    sort rating desc;
                    limit 6;'
            ])->post('https://api.igdb.com/v4/games/')->json();

            dd($askGames1);


        $games = Http::withHeaders(
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
            where platforms = (48, 49, 130, 6);
            sort total_rating_count desc;
            limit 12;",
            "text/plain"
        )->post('https://api.igdb.com/v4/games')
        ->json();

        echo("<pre>");
        var_dump('ffff');
        var_dump($games);
        var_dump(config('services.igdb'));
        // var_dump(['Client-ID' => '3b19hczl70fuv7z27pbj8q4nnr2bih',
        // 'Authorization' => 'Bearer x9ecnxbk5t8n0qvdkrasj38hcj00c2']);
        echo("<pre>");
        die("stop dd");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');

        // $before = Carbon:: now()->subMonths(2)->timestamp;
        // $after = Carbon::     now()->addMonths(2)->timestamp;
        // $afterFourMonths = Carbon:: now()->addMonths(4)->timestamp;
        // $current = Carbon:: now()->timestamp;

        // One big request
        // $popularGamesQuery = `fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count ;
        //     where platforms = (48, 49, 130, 6) & (first_release_date >= {$before} & first_release_date < {$after});
        //     sort popularity desc;
        //     limit 12;`;

        // $mainRequest = Http::withHeaders(
        //     config('services.igdb')
        // )->withBody(
        //     "query games \"Popular Games\" {
        //         ${popularGamesQuery}
        //     };
        //     query games \"Recently Review\" {

        //         fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count, summary ;
        //         where platforms = (48, 49, 130, 6) & (first_release_date >= {$before} & first_release_date < ${current} &
        //             rating_count > 5
        //         );
        //         sort rating desc;
        //         limit 3;
        //     };
        //     query games \"Most Anticipated Games\" {
        //         fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating ;
        //         where platforms = (48, 49, 130, 6) & (first_release_date >= {$current} & first_release_date < ${afterFourMonths});
        //         sort popularity desc;
        //         limit 4;
        //     };

        //     query games \"Comming soon games\" {
        //         fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating ;
        //         where platforms = (48, 49, 130, 6) & (first_release_date >= {$current} & popularity > 5);
        //         sort first_release_date asc;
        //         limit 4;
        //     };
        //     "
        //      // query games 'Playstation Games 2\\' {fields name,platforms.name; where platforms !=n & platforms = {48}; limit 1; };"
        //      , 'text/plain')->post('https://api-v3.igdb.com/multiquery', )->json();


        // $popularGames = Http::withHeaders(
        //     config('services.igdb')
        // )->withOptions([
        //     'body' =>
        //         "fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count ;
        //         where platforms = (48, 49, 130, 6) & (first_release_date >= {$before} & first_release_date < ${current});
        //         sort popularity desc;
        //         limit 12;"
        // ])->get('https://api-v3.igdb.com/games/')->json();

        // $recentlyReviewGames = Http::withHeaders(
        //     config('services.igdb')
        // )->withOptions([
        //     'body' =>
        //         "fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count, summary ;
        //         where platforms = (48, 49, 130, 6) & (first_release_date >= {$before} & first_release_date < ${current} &
        //             rating_count > 5
        //         );
        //         sort rating desc;
        //         limit 3;"
        // ])->get('https://api-v3.igdb.com/games/')->json();

        // $mostAnticipatedGames = Http::withHeaders(
        //     config('services.igdb')
        // )->withOptions([
        //     'body' =>
        //         "fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating ;
        //         where platforms = (48, 49, 130, 6) & (first_release_date >= {$current} & first_release_date < ${afterFourMonths});
        //         sort popularity desc;
        //         limit 4;"
        // ])->get('https://api-v3.igdb.com/games/')->json();

        // $commingSoonGames = Http::withHeaders(
        //     config('services.igdb')
        // )->withOptions([
        //     'body' =>
        //         "fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating ;
        //         where platforms = (48, 49, 130, 6) & (first_release_date >= {$current} & popularity > 5);
        //         sort first_release_date asc;
        //         limit 4;"
        // ])->get('https://api-v3.igdb.com/games/')->json();

        // return view('index', [
        //     // 'popularGames' => $popularGames,
        //     // 'recentlyReviewGames' => $recentlyReviewGames,
        //     // 'mostAnticipatedGames' => $mostAnticipatedGames,
        //     // 'commingSoonGames' => $commingSoonGames,
        // ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  slug  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $gammes =  Http::withHeaders(
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
        

        // dd($gammes[0]);



        // $gameUnformated = Http::withHeaders(
        //     config('services.igdb')
        // )->withOptions([
        //     'body' =>
        //         "fields *,
        //             cover.*,
        //             genres.*,
        //             involved_companies.company.name,
        //             platforms.abbreviation,
        //             videos.*,
        //             screenshots.*,
        //             similar_games.*,
        //             similar_games.cover.*,
        //             similar_games.platforms.abbreviation,
        //             websites.* ;
        //         where slug = \"$slug\";"
        // ])->get('https://api-v3.igdb.com/games/')->json();

        $gameUnformated = Http::withHeaders(
            config('services.igdb')
        )->withBody(
            "fields *,
                    cover.*,
                    genres.*,
                    involved_companies.company.name,
                    platforms.abbreviation,
                    videos.*,
                    screenshots.*,
                    similar_games.*,
                    similar_games.cover.*,
                    similar_games.platforms.abbreviation,
                    websites.* ;
                where slug = \"$slug\";",
            "text/plain"
        )->post('https://api.igdb.com/v4/games')
        ->json();

        abort_if(!$gameUnformated, 404);

        $formatedGame = $this->formatGameForView($gameUnformated[0]);

        // dump($formatedGame);

        return view('show',[
            'game' => $formatedGame
        ]);
    }

    private function formatGameForView($game) {

        return collect($game)->merge([
            'bigCover' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
            // 'genres' => collect($game['genres'])->pluck('name')->implode(', '),
            'genres' => null,
            'companies' => array_key_exists('involved_companies', $game) ? collect($game['involved_companies'])->pluck('company')->pluck('name')->implode(', ') : null,
            'platforms' => collect($game['platforms'])->pluck('abbreviation')-> implode(', '),
            'rating' => isset($game['rating']) ? round($game['rating']) : 70,
            'criticRating' => isset($game['aggregated_rating']) ? round($game['aggregated_rating']) : 0,
            'gameUrl' => route('games.show', $game['slug']),
            'trailer' => array_key_exists('videos', $game) ?
                "https://youtube.com/embed/{$game['videos'][0]['video_id']}":
                '',

            'screenshots' => collect($game['screenshots'])->take(6)->pluck('url')->map(
                function ($url){
                return [
                    'big' => Str::replaceFirst('thumb', 'screenshot_big', $url),
                    'huge' => Str::replaceFirst('thumb', 'screenshot_huge', $url),
                ];
            }),
            'similarGames' => collect($game['similar_games'])->take(6)->map(
                function ($similarGame) {
                    return [
                        'name' => $similarGame['name'],
                        'slug' => $similarGame['slug'],
                        'url' => route('games.show', $similarGame['slug']),
                        'cover' => array_key_exists('cover', $similarGame) ?
                            Str::replaceFirst('thumb', 'logo_med', $similarGame['cover']['url']) : '',
                        // @todo add default cover image
                        'rating' => isset($similarGame['rating']) ? round($similarGame['rating']) : null,
                        'platforms' => array_key_exists('platforms', $similarGame) ?
                            collect($similarGame['platforms'])->pluck('abbreviation')->implode(', ') : '',
                    ];
                }
            ),
            'social' => array(
                'website' => isset($game['websites']) ? collect($game['websites'])->pluck('url')->first() : null,
                'facebook' =>  isset($game['websites']) ?
                    collect($game['websites'])->pluck('url')->filter(function ($webs) {
                        return Str::contains($webs, 'facebook');
                    })->first() :
                    null,
                'twitter' => isset($game['websites']) ?
                    collect($game['websites'])->pluck('url')->filter(function ($webs) {
                        return Str::contains($webs, 'twitter');
                    })->first() :
                    null,
                'instagram' => isset($games['websites']) ? collect($game['websites'])->pluck('url')->filter(function ($webs) {
                        return Str::contains($webs, 'instagram');
                    })->first() :
                    null,
            ),
            'summary' => isset($game['summary']) ? $game['summary'] : 'Summary not available yet.'
        ])->toArray();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
