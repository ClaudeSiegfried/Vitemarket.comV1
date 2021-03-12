<?php

namespace Tests\Feature\Http\Controllers\Configurations;

use App\Mmoney;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Configurations\MmoneyController
 */
class MmoneyControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $mmoneys = factory(Mmoney::class, 3)->create();

        $response = $this->get(route('mmoney.index'));

        $response->assertOk();
        $response->assertViewIs('mmoney.index');
        $response->assertViewHas('mmoneys');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $mmoneys = factory(Mmoney::class, 3)->create();

        $response = $this->get(route('mmoney.create'));

        $response->assertOk();
        $response->assertViewIs('mmoney.create');
        $response->assertViewHas('mmoneys');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Configurations\MmoneyController::class,
            'store',
            \App\Http\Requests\Configurations\MmoneyStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $fam = $this->faker->word;
        $credential = $this->faker->word;

        $response = $this->post(route('mmoney.store'), [
            'fam' => $fam,
            'credential' => $credential,
        ]);

        $mmoneys = Mmoney::query()
            ->where('fam', $fam)
            ->where('credential', $credential)
            ->get();
        $this->assertCount(1, $mmoneys);
        $mmoney = $mmoneys->first();

        $response->assertRedirect(route('mmoney.create', [$mmoney]));
        $response->assertSessionHas('mmoney', $mmoney);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $mmoney = factory(Mmoney::class)->create();

        $response = $this->get(route('mmoney.show', $mmoney));

        $response->assertOk();
        $response->assertViewIs('mmoney.show');
        $response->assertViewHas('mmoney');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $mmoney = factory(Mmoney::class)->create();

        $response = $this->get(route('mmoney.edit', $mmoney));

        $response->assertOk();
        $response->assertViewIs('mmoney.edit');
        $response->assertViewHas('mmoney');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Configurations\MmoneyController::class,
            'update',
            \App\Http\Requests\Configurations\MmoneyUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $mmoney = factory(Mmoney::class)->create();
        $mmoney = $this->faker->word;

        $response = $this->put(route('mmoney.update', $mmoney), [
            'mmoney' => $mmoney,
        ]);

        $response->assertRedirect(route('mmoney.index', [$mmoney]));
        $response->assertSessionHas('mmoney', $mmoney);
    }
}
