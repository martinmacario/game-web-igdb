<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function the_game_page_shows_correct_game_info()
    {
        $response = $this->get(route('games.show'), 'factorio');

        $response->assertSuccessful();
    }
}
