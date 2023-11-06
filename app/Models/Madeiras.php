<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Madeiras extends Model
{


    protected $table = 'Madeiras';

    public $columnMapping = [
        'Tipo Madeira' => 'tipo_madeira',
        'Data Venda' => 'data_venda',
        'Valor Compra' => 'valor_compra',
        'Quantidade Comprada' => 'quantida_compra',
        'Valor Venda' => 'valor_venda',
        'Frete' => 'frete',
        'ICMS' => 'icms',
        'Lucro' => 'lucro',
        'Cliente' => 'cliente',

        // Adicione outros mapeamentos conforme necessário
    ];




}
