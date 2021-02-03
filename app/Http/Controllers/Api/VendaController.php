<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Cliente;
use App\Models\Venda;
use App\Models\ItemVenda;
use App\Models\Produto;


class VendaController extends Controller
{
    /**
     * NOVA VENDA
     * Verifica se cliente tem cadastro, se nao tiver, registra o cliente
     * Registra nova venda com referencia ao cliente
     * Registra itens do pedido com referencia a venda
     * Retorna mensagem com resultado obtido
     */
    public function novaVenda(Request $request){

        //Validacoes
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
                $newVenda = parent::registraVenda($inputTotal, $clienteCadastro, $inputPedido);
               
                //Registra itens do pedido fazendo referencia a venda
                parent::registraItemVenda($inputPedido, $newVenda);
                
                DB::commit();

                return response()->json(['message' => "Pedido realizado com sucesso! Entraremos em contato através do e-mail com as instruções de pagamento. Obrigado!"]);

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
                $newVenda = parent::registraVenda($inputTotal, $newCliente, $inputPedido);

                //Registra itens do pedido fazendo referencia a venda
                parent::registraItemVenda($inputPedido, $newVenda);

                DB::commit();

                return response()->json(['message' => "Pedido realizado com sucesso! Entraremos em contato através do e-mail com as instruções de pagamento. Obrigado!"]);

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


    // Retorna todas as vendas cadastradas
    public function listaVendas(){
        $vendas = Venda::all();
        return response()->json($vendas);
    }


    // retorna venda especifica e os produtos associados a ela
    public function showVenda($id)
    {
        //retorna a venda e o cliente associado a ela
        $venda = Venda::select('vendas.*', 'clientes.nome as cliente', 'clientes.email as email')
        ->join('clientes', 'clientes.id', 'vendas.id_cliente')
        ->where('vendas.id', $id)->first();

        //retorna os todos produtos da venda
        $produtos = ItemVenda::select('item_vendas.preco as preco', 'produtos.nome as nome')
        ->join('produtos', 'produtos.id', 'item_vendas.id_produto')
        ->where('item_vendas.id_venda', $id)->get();

        return response()->json([
            'venda' => $venda,
            'produtos' => $produtos,
        ]);
    }
    

    //Pagamento da venda (muda status da venda para "Pagamento efetuado")
    public function pagamentoVenda(Request $request){

        $id = $request->input('id'); //id da venda

        $venda = Venda::find($id);
        $venda->status = "Pagamento efetuado";
        $venda->save();

        return response()->json(['message' => "Status de pagamento atualizado com sucesso!"]);
    }
}
