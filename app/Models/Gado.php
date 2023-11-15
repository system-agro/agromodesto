<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Gado extends Model
{
    

    protected $table = 'Gado';

    public $columnMapping = [
        'Cliente' => 'cliente',
        'Data Venda' => 'data_venda',
        'Valor Venda' => 'valor_venda',
        'Comissao' => 'comissao',
        'Valor Frete' => 'valor_frete',
        'Lucro' => 'lucro'

        // Adicione outros mapeamentos conforme necessário
    ];
    
}
