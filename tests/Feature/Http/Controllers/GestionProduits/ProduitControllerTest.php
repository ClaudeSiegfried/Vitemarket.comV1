<?php

namespace Tests\Feature\Http\Controllers\GestionProduits;

use App\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GestionProduits\ProduitController
 */
class ProduitControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $produits = factory(Produit::class, 3)->create();

        $response = $this->get(route('produit.index'));

        $response->assertOk();
        $response->assertViewIs('produit.index');
        $response->assertViewHas('produits');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $produits = factory(Produit::class, 3)->create();

        $response = $this->get(route('produit.create'));

        $response->assertOk();
        $response->assertViewIs('produit.create');
        $response->assertViewHas('produits');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GestionProduits\ProduitController::class,
            'store',
            \App\Http\Requests\GestionProduits\ProduitStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $produit = $this->faker->word;

        $response = $this->post(route('produit.store'), [
            'produit' => $produit,
        ]);

        $produits = Produit::query()
            ->where('produit', $produit)
            ->get();
        $this->assertCount(1, $produits);
        $produit = $produits->first();

        $response->assertRedirect(route('produit.create'));
        $response->assertSessionHas('produit', $produit);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $produit = factory(Produit::class)->create();

        $response = $this->get(route('produit.show', $produit));

        $response->assertOk();
        $response->assertViewIs('produit.show');
        $response->assertViewHas('produit');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $produit = factory(Produit::class)->create();

        $response = $this->get(route('produit.edit', $produit));

        $response->assertOk();
        $response->assertViewIs('produit.edit');
        $response->assertViewHas('produit');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GestionProduits\ProduitController::class,
            'update',
            \App\Http\Requests\GestionProduits\ProduitUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $produit = factory(Produit::class)->create();
        $produit = $this->faker->word;

        $response = $this->put(route('produit.update', $produit), [
            'produit' => $produit,
        ]);

        $response->assertRedirect(route('produit.show', [$produit]));
        $response->assertSessionHas('produit', $produit);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $produit = factory(Produit::class)->create();

        $response = $this->delete(route('produit.destroy', $produit));

        $response->assertRedirect(route('produit.index'));

        $this->assertDeleted($produit);
    }
}
