<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Vendedor;
use App\Models\Venda;
use Tests\TestCase;

class VendaTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function check_if_venda_columns_is_correct()
    {

        $venda    = new Venda;
        $expected = ['id', 'vendedor_id', 'valor', 'comissao'];
        $compare  = array_diff($expected, $venda->getFillable());
        $this->assertEquals(0, count($compare));
        
    }

    /** @test */
    public function check_if_venda_creatinig_correct()
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
        $this->assertNotEmpty($venda->id);
        
    }

}
