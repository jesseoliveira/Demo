<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Vendedor;
use Tests\TestCase;

class VendedorTest extends TestCase
{

    use RefreshDatabase;
    
    /** @test */
    public function checking_api_request_endpoint_vendedor_list()
    {
        $response = $this->get('/api/list/vendedores');
        $response->assertStatus(200)->assertJson([
            'state' => 'SUCCESS',
        ]);
    }

    /** @test */
    public function checking_post_api_request_to_register_vendedor()
    {
        $faker = Vendedor::factory()->make();
        $response = $this->post('/api/create/vendedor', [
            'name'  => $faker->name,
            'email' => $faker->email
        ]);

        $response->assertStatus(200)->assertJson([
            'state' => 'SUCCESS',
        ]);

    }

    /** @test */
    public function checking_post_api_request_to_destroy_register_vendedor()
    {

        $faker = Vendedor::factory()->make();
        $vendedor = new Vendedor;
        $vendedor->name  = $faker->name;
        $vendedor->email = $faker->email;
        $vendedor->save();

        $response = $this->post('/api/delete/vendedor', [
            'id' => $vendedor->id
        ]);

        $response->assertStatus(200)->assertJson([
            'state' => 'SUCCESS',
        ]);

    }
}