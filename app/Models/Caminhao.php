<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Caminhao extends Model
{
    

    protected $table = 'Caminhao';
    public $columnMapping = [
        'Placa' => 'placa',
        'Data Frete' => 'data_frete',
        'Valor Combustivel' => 'valor_combustivel',
        'Km Inicial' => 'km_inicial',
        'Valor Frete' => 'valor_frete',
        'Valor Manutencao' => 'valor_manutencao',
        'Lucro' => 'lucro',
        'Quantidade Combutivel' => 'quantidade_litro_combustivel'
        // Adicione outros mapeamentos conforme necessário
    ];
    

    

    
}
