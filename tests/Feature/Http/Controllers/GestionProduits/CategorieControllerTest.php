<?php

namespace Tests\Feature\Http\Controllers\GestionProduits;

use App\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GestionProduits\CategorieController
 */
class CategorieControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $categories = factory(Categorie::class, 3)->create();

        $response = $this->get(route('categorie.index'));

        $response->assertOk();
        $response->assertViewIs('categorie.index');
        $response->assertViewHas('categories');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $categories = factory(Categorie::class, 3)->create();

        $response = $this->get(route('categorie.create'));

        $response->assertOk();
        $response->assertViewIs('categorie.create');
        $response->assertViewHas('categories');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GestionProduits\CategorieController::class,
            'store',
            \App\Http\Requests\GestionProduits\CategorieStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $libele = $this->faker->word;

        $response = $this->post(route('categorie.store'), [
            'libele' => $libele,
        ]);

        $categories = Categorie::query()
            ->where('libele', $libele)
            ->get();
        $this->assertCount(1, $categories);
        $categorie = $categories->first();

        $response->assertRedirect(route('categorie.create'));
        $response->assertSessionHas('categorie', $categorie);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $categorie = factory(Categorie::class)->create();

        $response = $this->get(route('categorie.show', $categorie));

        $response->assertOk();
        $response->assertViewIs('categorie.show');
        $response->assertViewHas('categorie');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $categorie = factory(Categorie::class)->create();

        $response = $this->get(route('categorie.edit', $categorie));

        $response->assertOk();
        $response->assertViewIs('categorie.edit');
        $response->assertViewHas('categorie');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GestionProduits\CategorieController::class,
            'update',
            \App\Http\Requests\GestionProduits\CategorieUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $categorie = factory(Categorie::class)->create();
        $categorie = $this->faker->word;

        $response = $this->put(route('categorie.update', $categorie), [
            'categorie' => $categorie,
        ]);

        $response->assertRedirect(route('categorie.show', [$categorie]));
        $response->assertSessionHas('categorie', $categorie);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $categorie = factory(Categorie::class)->create();

        $response = $this->delete(route('categorie.destroy', $categorie));

        $response->assertRedirect(route('categorie.index'));

        $this->assertDeleted($categorie);
    }
}
