<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Venda;

class VendaTest extends TestCase
{
    /** @test */
    public function check_if_venda_columns_is_correct()
    {

        $venda    = new Venda;
        $expected = ['id', 'vendedor_id', 'valor', 'comissao'];
        $compare  = array_diff($expected, $venda->getFillable());
        $this->assertEquals(0, count($compare));
        
    }
}
