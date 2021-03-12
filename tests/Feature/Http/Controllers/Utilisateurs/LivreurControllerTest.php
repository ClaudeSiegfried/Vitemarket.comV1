<?php

namespace Tests\Feature\Http\Controllers\Utilisateurs;

use App\Livreur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Utilisateurs\LivreurController
 */
class LivreurControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $livreurs = factory(Livreur::class, 3)->create();

        $response = $this->get(route('livreur.index'));

        $response->assertOk();
        $response->assertViewIs('livreur.index');
        $response->assertViewHas('livreurs');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $livreurs = factory(Livreur::class, 3)->create();

        $response = $this->get(route('livreur.create'));

        $response->assertOk();
        $response->assertViewIs('livreur.create');
        $response->assertViewHas('livreurs');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Utilisateurs\LivreurController::class,
            'store',
            \App\Http\Requests\Utilisateurs\LivreurStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $etablissement = $this->faker->word;
        $user_id = $this->faker->randomDigitNotNull;

        $response = $this->post(route('livreur.store'), [
            'etablissement' => $etablissement,
            'user_id' => $user_id,
        ]);

        $livreurs = Livreur::query()
            ->where('etablissement', $etablissement)
            ->where('user_id', $user_id)
            ->get();
        $this->assertCount(1, $livreurs);
        $livreur = $livreurs->first();

        $response->assertRedirect(route('livreur.create', [$livreur]));
        $response->assertSessionHas('livreur', $livreur);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $livreur = factory(Livreur::class)->create();

        $response = $this->get(route('livreur.show', $livreur));

        $response->assertOk();
        $response->assertViewIs('livreur.show');
        $response->assertViewHas('livreur');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $livreur = factory(Livreur::class)->create();

        $response = $this->get(route('livreur.edit', $livreur));

        $response->assertOk();
        $response->assertViewIs('livreur.edit');
        $response->assertViewHas('livreur');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Utilisateurs\LivreurController::class,
            'update',
            \App\Http\Requests\Utilisateurs\LivreurUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $livreur = factory(Livreur::class)->create();
        $livreur = $this->faker->word;

        $response = $this->put(route('livreur.update', $livreur), [
            'livreur' => $livreur,
        ]);

        $response->assertRedirect(route('livreur.index', [$livreur]));
        $response->assertSessionHas('livreur', $livreur);
    }
}
