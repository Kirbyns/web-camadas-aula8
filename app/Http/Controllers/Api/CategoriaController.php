<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoriaRequest;
use Illuminate\Support\Str;


class CategoriaController extends Controller
{
    public function index(Request $request)
    {


        $sortParameter = $request->input('ordenacao', 'nome_da_categoria');
        $sortDirection = Str::startsWith($sortParameter, '-') ? 'desc' : 'asc';
        $sortColumn = ltrim($sortParameter, '-');

        if($sortColumn == 'nome_da_categoria'){
            $categorias = Categoria::orderBy('nomedacategoria', $sortDirection)->get();

        } else {
            $categorias = Categoria::all();

        }


         return response() -> json([
            'status' => 200,
           'mensagem' => 'Lista de categorias retornada',
            'categorias' => CategoriaResource::collection($categorias)
         ], 200);

    }

    public function create()
    {
        //
    }

    public function store(StoreCategoriaRequest $request)
    {
        $categoria = new Categoria();
        $categoria->nomedacategoria = $request->nome_da_categoria;
        $categoria->save();

        return response() -> json([
            'status' => 200,
            'mensagem' => 'Categoria criada',
            'categorias' => new CategoriaResource($categoria)
        ], 200);
    }

    public function show(Categoria $categoria)
    {
        //
    }

    public function edit(Categoria $categoria)
    {
        //
    }

    public function update(StoreCategoriaRequest $request, Categoria $categoria)
    {
        $categoria = Categoria::find($categoria->pkcategoria);
        $categoria->nomedacategoria = $request->nome_da_categoria;
        $categoria->update();
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return response() -> json([
            'status' => 200,
            'mensagem' => 'Categoria apagada',
        ], 200);
    }



}
