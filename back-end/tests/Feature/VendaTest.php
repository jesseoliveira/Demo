<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Venda;
use Tests\TestCase;

class VendaTest extends TestCase
{
    /** @test */
    public function checking_api_request_endpoint_venda_list()
    {
        $response = $this->get('/api/list/vendas');
        $response->assertStatus(200)->assertJson([
            'state' => 'SUCCESS',
        ]);
    }

    /** @test */
    public function checking_post_api_request_to_register_venda()
    {

        $response = $this->post('/api/create/venda', [
            'vendedor_id' => 1,
            'valor'       => 100, 
            'comissao'    => 8.5
        ]);

        $response->assertStatus(200)->assertJson([
            'state' => 'SUCCESS',
        ]);

    }

    /** @test */
    public function checking_post_api_request_to_destroy_register_venda()
    {
        $venda = (new Venda)::first();

        if($venda->id > 0){
            $response = $this->post('/api/delete/venda', [
                'id' => $venda->id
            ]);

            $response->assertStatus(200)->assertJson([
                'state' => 'SUCCESS',
            ]);
        }

    }
}
