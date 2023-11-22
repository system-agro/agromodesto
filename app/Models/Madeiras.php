<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CompraMadeira;


class Madeiras extends Model
{


    protected $table = 'Madeiras';

    public $columnMapping = [
        'Data Venda' => 'data_venda',
        'Valor Compra' => 'valor_compra',
        'Quantidade Comprada' => 'quantida_compra',
        'Valor Venda' => 'valor_venda',
        'Frete' => 'frete',
        'ICMS' => 'icms',
        'Lucro' => 'lucro',
        'Cliente' => 'cliente',
        'Quantidade Venda' => 'quantidade_venda'

        // Adicione outros mapeamentos conforme necessário
    ];

    protected $fillable = [
        'data_venda',
        'valor_venda',
        'quantidade_venda',
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
