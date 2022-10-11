<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index(Request $request){
         //Captura a entrada a pagina

         $query = Produto::with('categoria');

         //$filterParameter = $request =>input('filtro');

         //montar a query com e sem paginacao

         $query = Produto::with('categoria');
        if ($filterParameter == null){
            //retorna todos os produtos
            $produtos = $query->get();

            $response = response()->json([
                'status' => 200,
                'mensagem' => 'Lista de produtos retornada',
                'produtos' => ProdutoResource::collection($produtos)],200);


        }
        else {
            [$filterCriteria, $filterValue] = explode(":", $filterParameter);

            //se o filtro está adequado
            if($filterCriteria == "nome_da_categoria"){
                //faz inner join para obter a categoria
                $produtos = $query->join("categorias","pkcategoria","=", "fkcategoria") ->where("nomedacategoria","=",$filterValue)->get();

                $response = response()->json([
                    'status' => 200,
                    'mensagem'=> 'Lista de produtos retornada filtrada',
                    'produtos' => ProdutoResource::collection($produtos)
                ],200);
            }
            else{
                //usuario chamou um filtro que nao existe, entao nao há nada a retornar (erro 406 - Not Accepted)
                $response = response()->json([
                    'status' => 406,
                    'mensagem'=>'Filtro nao aceito',
                    'produtos'=>[]
                ], 406);
            }
        }
            //retorna a resposta processada

            return($response);
    }





}
