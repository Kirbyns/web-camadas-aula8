<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    //campos publicaveis

    protected $fillable = ['nomedoproduto','anodoproduto','precodelista'];


    //nome da chave primaria


    protected $primaryKey = 'pkproduto';


    //Nome da tabela

    protected $table = 'produtos';

    //informa que esta trabalhando com incremento

    public $incrementing = true;

    //não utiliza timestamp nos controles (created e updated)

    public $timestamps = false;


    public function categoria(){
        return $this -> belongsTo(Categoria::class, 'fkcategoria', 'pkcategoria');
    }
}
