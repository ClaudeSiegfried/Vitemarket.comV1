<?php

namespace Tests\Feature\Http\Controllers\GestionProduits;

use App\Marque;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GestionProduits\MarqueController
 */
class MarqueControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $marques = factory(Marque::class, 3)->create();

        $response = $this->get(route('marque.index'));

        $response->assertOk();
        $response->assertViewIs('marque.index');
        $response->assertViewHas('marques');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $marques = factory(Marque::class, 3)->create();

        $response = $this->get(route('marque.create'));

        $response->assertOk();
        $response->assertViewIs('marque.create');
        $response->assertViewHas('marques');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GestionProduits\MarqueController::class,
            'store',
            \App\Http\Requests\GestionProduits\MarqueStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $libele = $this->faker->word;

        $response = $this->post(route('marque.store'), [
            'libele' => $libele,
        ]);

        $marques = Marque::query()
            ->where('libele', $libele)
            ->get();
        $this->assertCount(1, $marques);
        $marque = $marques->first();

        $response->assertRedirect(route('marque.create', [$marque]));
        $response->assertSessionHas('marque', $marque);
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $marque = factory(Marque::class)->create();

        $response = $this->get(route('marque.edit', $marque));

        $response->assertOk();
        $response->assertViewIs('marque.edit');
        $response->assertViewHas('marque');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GestionProduits\MarqueController::class,
            'update',
            \App\Http\Requests\GestionProduits\MarqueUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $marque = factory(Marque::class)->create();
        $libele = $this->faker->word;

        $response = $this->put(route('marque.update', $marque), [
            'libele' => $libele,
        ]);

        $response->assertRedirect(route('marque.index', [$marque]));
        $response->assertSessionHas('marque', $marque);
    }
}
