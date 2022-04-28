<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Vendedor;
use Tests\TestCase;

class VendedorTest extends TestCase
{
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

        $response = $this->post('/api/create/vendedor', [
            'name'  => 'Laura Nunes',
            'email' => 'laura@gmail.com'
        ]);

        $response->assertStatus(200)->assertJson([
            'state' => 'SUCCESS',
        ]);

    }

    /** @test */
    public function checking_post_api_request_to_destroy_register_vendedor()
    {

        $vendedor = (new Vendedor)::first();

        if($vendedor->id > 0){

            $response = $this->post('/api/delete/vendedor', [
                'id' => $vendedor->id
            ]);

            $response->assertStatus(200)->assertJson([
                'state' => 'SUCCESS',
            ]);

        }

    }
}