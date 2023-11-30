<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Gado;

class Client extends Model
{


    protected $table = 'client';

    public $columnMapping = [
        'Nome' => 'name',
        'Email' => 'email',
        'Telefone' => 'phone',
        'Documento' => 'docuemento',
        'Estado' => 'estado',
        'Cidade' => 'cidade',
        'Bairro' => 'bairro',
        // Adicione outros mapeamentos conforme necessário
    ];

    // No arquivo Client.php
    public function gados()
    {
        return $this->hasMany(Gado::class, 'client_id');
    }



}
