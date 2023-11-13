<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Fornecedor extends Model
{
    

    protected $table = 'Fornecedor';

    public $columnMapping = [
        'Nome' => 'name',
        'Email' => 'email',
        'Telefone' => 'phone',
        'Documento' => 'documento',
        'Estado' => 'estado',
        'Cidade' => 'cidade',
        // Adicione outros mapeamentos conforme necessário
    ];

    
}
