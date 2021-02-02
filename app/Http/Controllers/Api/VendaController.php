<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Venda;
use App\Models\ItemVenda;

class VendaController extends Controller
{

    /**
     * NOVA VENDA
     * Verifica se cliente tem cadastro, se nao tiver registra o cliente
     * Registra nova venda com referencia ao cliente
     * Registra itens do pedido com referencia a venda
     */
    public function novaVenda(Request $request){

        //Armazenando inputs em variaveis (nome do cliente, email do cliente, pedido, tamanho do pedido, valor total)
        $clienteNome = $request->input('cliente.nome');
        $clienteEmail = $request->input('cliente.email');

        $pedido = $request->input('pedido');
        $tamanhoPedido = count($pedido);

        $total = $request->input('total');
        //---------------------------------------------------

        // Faz busca do cliente usando o email do cliente informado no input
        $clienteCadastro = Cliente::where('email', $clienteEmail)->first();

        /**
         * Verifica se o registro foi encontrado e se confere com o nome do cliente
         * Se sim, registra a venda para o cliente encontrado no banco dados
         * Se não, registra o cliente no banco de dados e uma venda para o mesmo
         */
        if($clienteCadastro && ($clienteCadastro->nome == $clienteNome)){

            //Registra venda para o cliente
            $venda = new Venda;
            $venda->valor = $request->input('total');
            $venda->status = null;
            $venda->id_cliente = $clienteCadastro->id;
            $venda->save();
            //----------------------------------------

            // Percorre o array de pedido e registra um itemVenda para cada item 
            for($i = 0; $i < $tamanhoPedido; $i++){
                $item = new ItemVenda;
                $item->preco = $pedido[$i]['preco'];
                $item->id_produto = $pedido[$i]['id'];
                $item->id_venda = $venda->id;
                $item->save();
            }
            //-------------------------------------------------

            return response()->json(
                [
                    'cliente' => $clienteCadastro,
                    'venda' => $venda,
                    'item' => $item

                ]
            );

        }else{
            
            //Registra cliente
            $cliente = new Cliente;
            $cliente->nome = $clienteNome;
            $cliente->email = $clienteEmail;
            $cliente->save();
            //---------------------------------

            //Registra venda para o cliente
            $venda = new Venda;
            $venda->valor = $request->input('total');
            $venda->status = null;
            $venda->id_cliente = $cliente->id;
            $venda->save();
            //----------------------------------------

            // Percorre o array de pedido e registra um itemVenda para cada item 
            for($i = 0; $i < $tamanhoPedido; $i++){
                $item = new ItemVenda;
                $item->preco = $pedido[$i]['preco'];
                $item->id_produto = $pedido[$i]['id'];
                $item->id_venda = $venda->id;
                $item->save();
            }
            //-------------------------------------------------

            return response()->json(
                [
                    'cliente' => $cliente,
                    'venda' => $venda,
                    'item' => $item

                ]
            );
        }
        //Fim verificacao de cliente e registro de nova venda------------------

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
