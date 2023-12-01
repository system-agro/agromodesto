<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Gado;
use App\Models\Madeiras;

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
    public function madeiras()
    {
        return $this->hasMany(Madeiras::class, 'client_id');
    }



}
