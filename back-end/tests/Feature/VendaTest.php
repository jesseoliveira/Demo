<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Vendedor;
use App\Models\Config;
use App\Models\Venda;
use Tests\TestCase;

class VendaTest extends TestCase
{
    use RefreshDatabase;
    
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
        $config = new Config;
        $config->comissao_venda = 8.5;
        $config->save();

        $faker = Venda::factory()->make();
        $response = $this->post('/api/create/venda', [
            'vendedor_id' => $faker->vendedor_id,
            'valor'       => $faker->valor, 
            'comissao'    => $faker->comissao
        ]);

        $response->assertStatus(200)->assertJson([
            'state' => 'SUCCESS',
        ]);

    }

    /** @test */
    public function checking_post_api_request_to_destroy_register_venda()
    {
        $faker = Vendedor::factory()->make();
        $vendedor = new Vendedor;
        $vendedor->name  = $faker->name;
        $vendedor->email = $faker->email;
        $vendedor->save();

        $faker = Venda::factory()->make();
        $venda = new Venda;
        $venda->vendedor_id  = $vendedor->id;
        $venda->valor        = $faker->valor;
        $venda->comissao     = $faker->comissao;
        $venda->save();
        
        $response = $this->post('/api/delete/venda', [
            'id' => $venda->id
        ]);

        $response->assertStatus(200)->assertJson([
            'state' => 'SUCCESS',
        ]);

    }
}
