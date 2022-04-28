<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $valor    = mt_rand(1, 4);
        $comissao = round(($valor*8.5/100),2);
        return [
            'vendedor_id' => $this->faker->randomNumber(),
            'valor'       => $valor,
            'comissao'    => $comissao
        ];
    }
}
