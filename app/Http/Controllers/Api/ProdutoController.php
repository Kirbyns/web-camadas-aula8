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

         $input = $request->input('pagina');

         //montar a query com e sem paginacao

         $query = Produto::with('categoria');

         if($input){
            $page = $input;
            $perPage = 10; //registro por página
            $query->offset(($page-1) * $perPage)->limit($perPage);
            $produtos = $query->get();

            $recordsTotal = Produto::count();
            $numberOfPages = ceil($recordsTotal / $perPage);

            $response = response()-> json([
                'status' => 200,
                'mensagem' => 'Lista de produtos retornada',
                'produtos' => ProdutoResource::collection($produtos),
                'meta' => [
                    'total_numero_de_registros' => (string) $recordsTotal,
                    'numero_de_registros_por_pagina' =>(string) $perPage,
                    'numero_de_paginas' =>(string) $numberOfPages,
                    'pagina_atual' => $page
                ]
                ], 200);

         } else{
            $produtos = $query->get();
            $response = response()-> json([
                'status' =>200,
                'mensagem' => 'Lista de produtos retornada',
                'produtos' =>ProdutoResource::collection($produtos)
            ]);
         }
    }





}
