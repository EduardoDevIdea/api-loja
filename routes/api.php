<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\VendaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Rota para listar todos os produtos
Route::get('/produtos', [ProdutoController::class, 'getProdutos']);

//Rota para realizar nova venda
Route::post('/venda', [VendaController::class, 'novaVenda']);

//Rota para listar todas as vendas
Route::get('/vendas', [VendaController::class, 'listaVendas']);

//Rota para mostrar venda especifica
Route::get('/show-venda/{id}', [VendaController::class, 'showVenda']);

//Rota para atualizar status de pagamento da venda
Route::post('/pagamento', [VendaController::class, 'pagamentoVenda']);

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */
