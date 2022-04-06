<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class SearchDropdown extends Component
{
    public $search = '';
    public $searchResult = [];

    public function render()
    {
        if (strlen($this->search) > 2) {


            $unformmattedGames = Http::withHeaders(
                config('services.igdb')
            )->withOptions([
                'body' => "
                    fields name, slug, cover.url;
                    where name ~ \"{$this->search}\"*;
                    sort rating desc;
                    limit 6;"

            ])->post('https://api.igdb.com/v4/games/')->json();

            $this->searchResult = null;
            $this->searchResult = $this->formatForView($unformmattedGames);
            // var_dump($unformmattedGames);
        }

        return view('livewire.search-dropdown');
    }

    public function formatForView($games)
    {
        return collect($games)->map(function($game) {
            return collect($game)->merge([
                'url' => isset($game['slug']) ? route('games.show', $game['slug']): '',
                'cover' => isset($game['cover']['url']) ?
                    Str::replaceFirst('thumb', 'cover_small', $game['cover']['url']) :
                    'https://via.placeholder.com/150',
            ]);
        })->toArray();
    }
}
