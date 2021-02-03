<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{

    //retorna todos os produtos
    public function getProdutos(){

        $produtos = Produto::all();

        return response()->json($produtos);

    }

}
