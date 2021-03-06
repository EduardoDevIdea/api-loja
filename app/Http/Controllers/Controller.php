<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Cliente;
use App\Models\Venda;
use App\Models\ItemVenda;
use App\Models\Produto;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Calcula previsao de entrega com base na maior data de previsão
    public function calculaPrevisao($pedido){
        $maiorPrevisao = 0;
        foreach($pedido as $item){
            $produto = Produto::where('id', $item['id'])->first();
            $previsao = $produto->previsao;
            if($previsao > $maiorPrevisao){
                $maiorPrevisao = $previsao;
            }
        }
        return $maiorPrevisao;
    }

    //Registra Cliente e retorna o registro criado
    public function registraCliente($clienteNome, $clienteEmail){
        $cliente = new Cliente;
        $cliente->nome = $clienteNome;
        $cliente->email = $clienteEmail;
        $cliente->save();
        return $cliente;
    }

    //registra venda e retorna venda criada
    public function registraVenda($total, $cliente, $pedido){
        $venda = new Venda;
        $venda->valor = $total;
        $venda->status = "Aguardando pagamento";
        $venda->id_cliente = $cliente->id;
        $venda->data = date('d/m/Y'); //data atual em formato string
        $venda->previsao = $this->calculaPrevisao($pedido);
        $venda->save();
        return $venda;
    }

    //registra cada item da venda
    public function registraItemVenda($pedido, $newVenda){
        foreach($pedido as $item){
            $itemVenda = new ItemVenda;
            $itemVenda->preco = $item['preco'];
            $itemVenda->id_produto =  $item['id'];
            $itemVenda->id_venda = $newVenda->id;
            $itemVenda->save();
        }
    }
}
