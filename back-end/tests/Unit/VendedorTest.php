<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Vendedor;

class VendedorTest extends TestCase
{
    /** @test */
    public function check_if_vendedor_columns_is_correct()
    {

        $vendedor = new Vendedor;
        $expected = ['id', 'name', 'email'];
        $compare  = array_diff($expected, $vendedor->getFillable());
        $this->assertEquals(0, count($compare));

    }

    /** @test */
    public function check_if_vendedor_creatinig_correct()
    {

        $faker = Vendedor::factory()->make();

        $vendedor = new Vendedor;
        $vendedor->name  = $faker->name;
        $vendedor->email = $faker->email;
        $vendedor->save();
        $this->assertNotEmpty($vendedor->id);
        
    }
   
}
