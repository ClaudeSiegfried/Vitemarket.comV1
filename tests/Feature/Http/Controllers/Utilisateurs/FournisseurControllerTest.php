<?php

namespace Tests\Feature\Http\Controllers\Utilisateurs;

use App\Fournisseur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Utilisateurs\FournisseurController
 */
class FournisseurControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $fournisseurs = factory(Fournisseur::class, 3)->create();

        $response = $this->get(route('fournisseur.index'));

        $response->assertOk();
        $response->assertViewIs('fournisseur.index');
        $response->assertViewHas('fournisseurs');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $fournisseurs = factory(Fournisseur::class, 3)->create();

        $response = $this->get(route('fournisseur.create'));

        $response->assertOk();
        $response->assertViewIs('fournisseur.create');
        $response->assertViewHas('fournisseurs');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Utilisateurs\FournisseurController::class,
            'store',
            \App\Http\Requests\Utilisateurs\FournisseurStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $etablissement = $this->faker->word;
        $user_id = $this->faker->randomDigitNotNull;

        $response = $this->post(route('fournisseur.store'), [
            'etablissement' => $etablissement,
            'user_id' => $user_id,
        ]);

        $fournisseurs = Fournisseur::query()
            ->where('etablissement', $etablissement)
            ->where('user_id', $user_id)
            ->get();
        $this->assertCount(1, $fournisseurs);
        $fournisseur = $fournisseurs->first();

        $response->assertRedirect(route('fournisseur.create', [$fournisseur]));
        $response->assertSessionHas('fournisseur', $fournisseur);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $fournisseur = factory(Fournisseur::class)->create();

        $response = $this->get(route('fournisseur.show', $fournisseur));

        $response->assertOk();
        $response->assertViewIs('fournisseur.show');
        $response->assertViewHas('fournisseur');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $fournisseur = factory(Fournisseur::class)->create();

        $response = $this->get(route('fournisseur.edit', $fournisseur));

        $response->assertOk();
        $response->assertViewIs('fournisseur.edit');
        $response->assertViewHas('fournisseur');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Utilisateurs\FournisseurController::class,
            'update',
            \App\Http\Requests\Utilisateurs\FournisseurUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $fournisseur = factory(Fournisseur::class)->create();
        $fournisseur = $this->faker->word;

        $response = $this->put(route('fournisseur.update', $fournisseur), [
            'fournisseur' => $fournisseur,
        ]);

        $response->assertRedirect(route('fournisseur.index', [$fournisseur]));
        $response->assertSessionHas('fournisseur', $fournisseur);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $fournisseur = factory(Fournisseur::class)->create();

        $response = $this->delete(route('fournisseur.destroy', $fournisseur));

        $response->assertRedirect(route('fournisseur.index'));

        $this->assertDeleted($fournisseur);
    }
}
