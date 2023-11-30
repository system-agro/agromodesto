<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Gado extends Model
{


    protected $table = 'Gado';

    public $columnMapping = [
        'Cliente' => 'cliente',
        'Data Venda' => 'data_venda',
        'Valor Venda' => 'valor_venda',
        'Comissao' => 'comissao',
        'Valor Frete' => 'valor_frete',
        'Lucro' => 'lucro',
        'Valor Compra' => 'valor_compra',

        // Adicione outros mapeamentos conforme necessário
    ];

    protected $fillable = [
        'client_id',
        'data_venda',
        'valor_venda',
        'comissao',
        'valor_frete',
        'lucro',
        'valor_compra'
        // Adicione todos os campos que você permite serem atribuídos em massa
        // ...
    ];

    // No arquivo Gado.php
    public function dataCliente()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }


}
