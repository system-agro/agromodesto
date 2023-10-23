<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    

    protected $table = 'client';

    public $columnMapping = [
        'Nome' => 'name',
        'Email' => 'email',
        'Telefone' => 'phone',
        // Adicione outros mapeamentos conforme necessário
    ];
    

    
}
