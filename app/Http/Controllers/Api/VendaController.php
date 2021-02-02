<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Cliente;


class VendaController extends Controller
{
    /**
     * NOVA VENDA
     * Verifica se cliente tem cadastro, se nao tiver, registra o cliente
     * Registra nova venda com referencia ao cliente
     * Registra itens do pedido com referencia a venda
     */
    public function novaVenda(Request $request){

        $request->validate([
            'cliente.nome' => ['required'],
            'cliente.email' => ['required', 'email'],
            'pedido' => ['required'],
            'total' => ['required']
        ]);

        //Armazenando inputs em variaveis 
        $inputClienteNome = $request->input('cliente.nome');
        $inputClienteEmail = $request->input('cliente.email');
        $inputPedido = $request->input('pedido');
        $inputTotal = $request->input('total');

        //Faz busca do cliente usando o email do cliente informado no input
        $clienteCadastro = Cliente::where('email', $inputClienteEmail)->first();

        //Se cliente tiver cadastro
        if($clienteCadastro && ($clienteCadastro->nome == $inputClienteNome)){
            
            try{
                DB::beginTransaction();

                //Registra nova venda fazendo referência ao cliente
                $newVenda = parent::registraVenda($inputTotal, $clienteCadastro);
               
                //Registra itens do pedido fazendo referencia a venda
                parent::registraItemVenda($inputPedido, $newVenda);
                
                DB::commit();
                return response()->json(
                    [
                        'message' => "Pedido realizado com sucesso! Entraremos em contato através do e-mail com as instruções de pagamento. Obrigado!",
                        'cliente' => $clienteCadastro,
                        'venda' => $newVenda
                    ]
                );

            }catch(\Exception $e){
                DB::rollBack();
                return response()->json(
                    [
                        'message' => "Erro ao finalizar seu pedido: Tente novamente e entre em contato conosco, se o erro persistir",
                        'erro' => $e
                    ]
                );
            }
            
        //Se cliente nao for cadastrado    
        }else{
            
            try{
                DB::beginTransaction();

                //Registra cliente
                $newCliente = parent::registraCliente($inputClienteNome, $inputClienteEmail);

                //Registra venda para o novo cliente  
                $newVenda = parent::registraVenda($inputTotal, $newCliente);

                //Registra itens do pedido fazendo referencia a venda
                parent::registraItemVenda($inputPedido, $newVenda);

                DB::commit();
                return response()->json(
                    [
                        'message' => "Pedido realizado com sucesso! Entraremos em contato através do e-mail com as instruções de pagamento. Obrigado!",
                        'cliente' => $newCliente,
                        'venda' => $newVenda
                    ]
                );

            }catch(\Exception $e){
                DB::rollBack();
                return response()->json(
                    [
                        'message' => "Erro ao finalizar seu pedido: Tente novamente e entre em contato conosco, se o erro persistir",
                        'erro' => $e
                    ]
                );
            }
        }
        //Fim verificacao de cliente e registro de nova venda
    }
    //Fim novaVenda

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
