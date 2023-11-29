<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CompraMadeira;


class Madeiras extends Model
{


    protected $table = 'Madeiras';

    public $columnMapping = [
        'Data Venda' => 'data_venda',
        'Valor Total Venda' => 'valor_total_venda',
        'Frete' => 'frete',
        'ICMS' => 'icms',
        'Lucro' => 'lucro',
        'Cliente' => 'cliente',
        // Adicione outros mapeamentos conforme necessário
    ];

    protected $fillable = [
        'data_venda',
        'valor_total_venda',
        'frete',
        'icms',
        'lucro',
        'cliente',
        // Outros campos conforme necessário
    ];
    // No modelo Madeira
    public function comprasMadeira()
    {
        return $this->hasMany(CompraMadeira::class, 'id_relatorio_madeira_fk', 'id');
    }




}
