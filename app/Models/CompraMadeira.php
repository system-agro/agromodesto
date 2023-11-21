<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Madeiras;


class CompraMadeira extends Model
{


    protected $table = 'compra_madeira';

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
        'Quantidade Venda' => 'quantidade_venda'

        // Adicione outros mapeamentos conforme necessário
    ];

    protected $fillable = [
      'tipo_madeira',
      'valo_compra',
      // Adicione todos os campos que você permite serem atribuídos em massa
      // ...
  ];

    public function madeira()
    {
        return $this->belongsTo(Madeiras::class, 'id_relatorio_madeira_fk', 'id');
    }

}
