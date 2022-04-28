<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'vendas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'vendedor_id', 'valor', 'comissao'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

   /* public function config(){
        return $this->hasOne('App\Models\Config');
    }*/

    public function comissao_venda()
    {
        return (Config::first())->comissao_venda;
    }

}
