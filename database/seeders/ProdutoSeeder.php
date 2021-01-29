<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produtos')->insert(
            [
                'nome' => 'iPhone 12 Mini 64 GB',
                'preco' => 6000,
                'codigo' => '01',
                'previsao' => 5,
                'img' => 'produto-01.jpg',
            ],
        );

        DB::table('produtos')->insert(
            [
                'nome' => 'iPhone 12 Pro 128 GB',
                'preco' => 9000,
                'codigo' => '02',
                'previsao' => 5,
                'img' => 'produto-02.jpg',
            ],
        );

        DB::table('produtos')->insert(
            [
                'nome' => 'iPhone SE 64 GB',
                'preco' => 3000,
                'codigo' => '03',
                'previsao' => 5,
                'img' => 'produto-03.jpg',
            ],
        );

        DB::table('produtos')->insert(
            [
                'nome' => 'AirPods',
                'preco' => 1200,
                'codigo' => '04',
                'previsao' => 7,
                'img' => 'produto-04.jpg',
            ],
        );
            
        DB::table('produtos')->insert(
            [
                'nome' => 'Película iPhone 12 Mini',
                'preco' => 120,
                'codigo' => '05',
                'previsao' => 2,
                'img' => 'produto-05.jpg',
            ],
        );

        DB::table('produtos')->insert(
            [
                'nome' => 'Capa iPhone 12 Mini',
                'preco' => 200,
                'codigo' => '06',
                'previsao' => 7,
                'img' => 'produto-06.jpg',
            ],
        );
            
        DB::table('produtos')->insert(
            [
                'nome' => 'Cabo Lightning 1 Metro Apple',
                'preco' => 100,
                'codigo' => '07',
                'previsao' => 2,
                'img' => 'produto-07.jpg',
            ],
        );

        DB::table('produtos')->insert(
            [
                'nome' => 'Carregador USB 20W Apple',
                'preco' => 150,
                'codigo' => '08',
                'previsao' => 5,
                'img' => 'produto-08.jpg',
            ],
        );
            
        DB::table('produtos')->insert(
            [
                'nome' => 'Carregador Portátil 10.000 MAh',
                'preco' => 125,
                'codigo' => '09',
                'previsao' => 7,
                'img' => 'produto-09.jpg',
            ],
        );

        DB::table('produtos')->insert(
            [
                'nome' => 'Caixa de Som Bluetooth 60W',
                'preco' => 450,
                'codigo' => '10',
                'previsao' => 7,
                'img' => 'produto-10.jpg',
            ],
        ); 
    }
}
