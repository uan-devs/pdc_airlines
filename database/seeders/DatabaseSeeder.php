<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Lucilio Gomes',
            'email' => 'lucilio@gmail.com',
            'password'=>Hash::make("1234")
        ]);

        DB::table("avioes")->insert([
            "modelo" => "BOEING 727",
            "descricao" => "Modelo da fabricante boeing",
            "capacidade"=> 60,
            "estado" => 0
        ]);

        DB::table("paises")->insert([
            ["nome"=> "Angola"],
            ["nome"=> "Portugal"],
            ["nome"=> "Brasil"]
        ]);

        DB::table("cidades")->insert([
            [ "nome" => "Luanda","codigo"=>"LDA","id_pais"=>1],
            ["nome" => "Lisboa","codigo"=>"LIS","id_pais"=>2],
            ["nome" => "Porto","codigo"=>"POR","id_pais"=>2],
            ["nome" => "Rio de Janeiro","codigo"=>"RIO","id_pais"=>3],
            ["nome" => "Brasília","codigo"=>"BRA","id_pais"=>3]
        ]);

        DB::table("aeroportos")->insert([
            ["nome"=> "4 de fevereiro", "id_cidade"=>1],
            ["nome"=> "Aeroporto de Lisboa", "id_cidade"=>2],
            ["nome"=> "Aeroporto de Porto", "id_cidade"=>3],
            ["nome"=> "Aeroporto Internacional do Rio de Janeiro", "id_cidade"=>4],
            ["nome"=> "Aeroporto Internacional de Brasilia", "id_cidade"=>5]
        ]);

        DB::table("classes")->insert([
            ["nome" => "economica"],
            ["nome" => "executiva"]
        ]);

        DB::table("tarifas")->insert([
            ["nome" => "basic", "id_classe" => 1],
            ["nome" => "discount", "id_classe"=>1]
        ]);

    }
}
