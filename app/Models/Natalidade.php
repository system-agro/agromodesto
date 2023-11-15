<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Natalidade extends Model
{
    

    protected $table = 'Natalidade';

    public $columnMapping = [
        'Numeracao Animal' => 'numeracao_animal',
        'Tipo' => 'tipo_animal',
        'Condicao' => 'gestante',
        'Data Inseminacao' => 'data_inseminacao',
        'Data Gestacao' => 'data_gestacao',

        // Adicione outros mapeamentos conforme necessário
    ];
    
}
