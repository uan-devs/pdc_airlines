@extends('admin.layout.template')
@section('title','PDC Airlines - Lista de Clientes')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Clientes Membros
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
            <div class="border rounded">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Genero</th>
                    <th scope="col">Idioma</th>
                    <th scope="col">Data de Nascimento</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefone</th>
                    <th>Milhas</th>
                    <th>Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($membros as $item)
                    <tr style="color: black;">
                        <td>{{$item->id}}</td>
                        <td> {{$item->titulo}}, {{$item->nome}} {{$item->sobrenome}}</td>
                        <td>{{$item->genero}}</td>
                        <td>{{$item->idioma}}</td>
                        <td>{{$item->data}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->telefone}}</td>
                        <td>{{$item->milhas}}</td>
                        <td>
                          <a href="#" class="px-3 btn  btn-info btn-sm">Ver</a>
                        </td>
                        
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="mt-2 p-2 w-full d-flex justify-content-center">
              <div class="">
               
              </div>
            </div>

        </div>


    </div>
</main>

@endsection