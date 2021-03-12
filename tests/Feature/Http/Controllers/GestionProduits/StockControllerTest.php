<?php

namespace Tests\Feature\Http\Controllers\GestionProduits;

use App\Produit;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GestionProduits\StockController
 */
class StockControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $stocks = factory(Stock::class, 3)->create();

        $response = $this->get(route('stock.index'));

        $response->assertOk();
        $response->assertViewIs('stock.index');
        $response->assertViewHas('stocks');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $stocks = factory(Stock::class, 3)->create();

        $response = $this->get(route('stock.create'));

        $response->assertOk();
        $response->assertViewIs('stock.create');
        $response->assertViewHas('produits');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GestionProduits\StockController::class,
            'store',
            \App\Http\Requests\GestionProduits\StockStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $stock = $this->faker->word;

        $response = $this->post(route('stock.store'), [
            'stock' => $stock,
        ]);

        $stocks = Stock::query()
            ->where('stock', $stock)
            ->get();
        $this->assertCount(1, $stocks);
        $stock = $stocks->first();

        $response->assertRedirect(route('stock.create'));
        $response->assertSessionHas('stock', $stock);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $stock = factory(Stock::class)->create();

        $response = $this->get(route('stock.show', $stock));

        $response->assertOk();
        $response->assertViewIs('stock.show');
        $response->assertViewHas('stock');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $stock = factory(Stock::class)->create();

        $response = $this->get(route('stock.edit', $stock));

        $response->assertOk();
        $response->assertViewIs('stock.edit');
        $response->assertViewHas('stock');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GestionProduits\StockController::class,
            'update',
            \App\Http\Requests\GestionProduits\StockUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $stock = factory(Stock::class)->create();
        $stock = $this->faker->word;

        $response = $this->put(route('stock.update', $stock), [
            'stock' => $stock,
        ]);

        $response->assertRedirect(route('stock.show', [$stock]));
        $response->assertSessionHas('stock', $stock);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $stock = factory(Stock::class)->create();

        $response = $this->delete(route('stock.destroy', $stock));

        $response->assertRedirect(route('stock.index'));

        $this->assertDeleted($stock);
    }
}
