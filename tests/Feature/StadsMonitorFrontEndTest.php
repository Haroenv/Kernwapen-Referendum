<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\City;

class StadsMonitorFrontEndTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @testdox Test of een gast bebruiker de pagina van de monitor kan bekijken zonder problemen.
     */
    public function indexPagina(): void
    {
        $this->get(route('stadsmonitor.index'))->assertStatus(200);
    }

    /**
     * @test
     * @testdox Test of de stadsmonitor zoekfunctie validatie fouten vertoont.
     */
    public function searchError(): void
    {
        $this->get(route('stadsmonitor.search'))
            ->assertStatus(302)
            ->assertSessionHasErrors();
    }

    /**
     * @test
     * @testdox Test of de stadsmonitor zoekfunctie geen fouten vertoont.
     */
    public function searchSuccess(): void
    {
        $this->call('GET', route('stadsmonitor.search'), ['term' => 'wtf'])
            ->assertStatus(200);
    }

    /**
     * @test 
     * @test Test of de gebruiker een juiste stad kan bekijken zonder fouten. 
     */
    public function showViewValidName(): void 
    {
        $this->get(route('stadsmonitor.show', ['name' => factory(City::class)->create()->name]))
            ->assertStatus(200);
    }

    /**
     * @test 
     * @testdox Test de error response wanneer een een gebruiker een foutieve stad wilt bekijken. 
     */
    public function showViewInValidId(): void 
    {
        $this->get(route('stadsmonitor.show', ['name' => 'Dwarventow']))
            ->assertStatus(404);
    }
}
