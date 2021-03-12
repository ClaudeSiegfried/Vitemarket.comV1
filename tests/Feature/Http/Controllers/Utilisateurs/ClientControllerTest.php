<?php

namespace Tests\Feature\Http\Controllers\Utilisateurs;

use App\Client;
use App\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Utilisateurs\ClientController
 */
class ClientControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $clients = factory(Client::class, 3)->create();

        $response = $this->get(route('client.index'));

        $response->assertOk();
        $response->assertViewIs('client.index');
        $response->assertViewHas('clients');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $clients = factory(Client::class, 3)->create();

        $response = $this->get(route('client.create'));

        $response->assertOk();
        $response->assertViewIs('client.create');
        $response->assertViewHas('roles');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Utilisateurs\ClientController::class,
            'store',
            \App\Http\Requests\Utilisateurs\ClientStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $client = $this->faker->word;

        $response = $this->post(route('client.store'), [
            'client' => $client,
        ]);

        $clients = Client::query()
            ->where('client', $client)
            ->get();
        $this->assertCount(1, $clients);
        $client = $clients->first();

        $response->assertRedirect(route('client.create'));
        $response->assertSessionHas('client', $client);
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $client = factory(Client::class)->create();

        $response = $this->get(route('client.edit', $client));

        $response->assertOk();
        $response->assertViewIs('client.edit');
        $response->assertViewHas('client');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Utilisateurs\ClientController::class,
            'update',
            \App\Http\Requests\Utilisateurs\ClientUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $client = factory(Client::class)->create();
        $client = $this->faker->word;

        $response = $this->put(route('client.update', $client), [
            'client' => $client,
        ]);

        $response->assertRedirect(route('client.show', [$client]));
        $response->assertSessionHas('client', $client);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $client = factory(Client::class)->create();

        $response = $this->delete(route('client.destroy', $client));

        $response->assertRedirect(route('client.index'));

        $this->assertDeleted($client);
    }
}
