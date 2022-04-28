<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\TestCase;
use App\Models\Vendedor;
use App\Models\Config;
use App\Models\Venda;

class FontendTest extends DuskTestCase
{
    private $frontend = '';

    /** @test */
    public function check_if_homepage_is_working()
    {
        $this->frontend = config('app.frontend');
        $this->browse(function (Browser $browser) {
            $browser->visit($this->frontend)
                    ->assertSee('Selecione');
        });
    }

    /** @test */
    public function check_if_create_new_vendedor_is_working()
    {
        $this->frontend = config('app.frontend');
        $this->browse(function (Browser $browser) {
            $faker = Vendedor::factory()->make();
            $browser->visit($this->frontend)
                    ->press('Cadastrar Vendedor')
                    ->type('name', $faker->name)
                    ->type('email', $faker->email)
                    ->press('Salvar');
        });
    }


    /** @test */
    public function check_if_page_list_vendedores_is_working()
    {

        $this->frontend = config('app.frontend');
        $this->browse(function (Browser $browser) {
            $browser->visit($this->frontend)
                    ->press('Listar Vendedores')
                    ->assertSee('Vendedores');
        });
    }


    /** @test */
    public function check_if_create_new_venda_is_working()
    {
        $this->frontend = config('app.frontend');
        $this->browse(function (Browser $browser) {
            $faker = Venda::factory()->make();
            $browser->visit($this->frontend)
                    ->press('Lançar Nova Venda')
                    ->select('vendedor',$faker->vendedor_id)
                    ->type('valor',$faker->valor)
                    ->press('Salvar');
        });
    }


    /** @test */
    public function check_if_page_list_vendas_is_working()
    {

        $this->frontend = config('app.frontend');
        $this->browse(function (Browser $browser) {
            $browser->visit($this->frontend)
                    ->press('Listar Vendas')
                    ->assertSee('Vendas Realizadas');
        });
    }
    
}
