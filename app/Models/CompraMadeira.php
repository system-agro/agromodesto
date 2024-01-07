<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Madeiras;


class CompraMadeira extends Model
{


    protected $table = 'compra_madeira';

    protected $fillable = [
      'tipo_madeira',
      'valo_compra',
      'valor_venda',
      'quantidade_venda',
      
      // Adicione todos os campos que você permite serem atribuídos em massa
      // ...
  ];

    public function madeira()
    {
        return $this->belongsTo(Madeiras::class, 'id_relatorio_madeira_fk', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($compraMadeira) {
            // Exclui a instância de CompraMadeira associada quando a instância de Madeiras é excluída
            $compraMadeira->delete();
        });
    }


}
