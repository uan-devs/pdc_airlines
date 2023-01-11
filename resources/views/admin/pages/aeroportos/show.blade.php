@extends('admin.layout.template')
@section('title', 'PDC Airline - aeroporto')

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Listagem de Aeroportos
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
            <div class="border rounded">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Estado</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($aeroporto as $aeroportos)
                    <tr style="color: black;">
                        <td>{{$aeroportos->id}}</td>
                        <td> {{$aeroportos->nome}}</td>
                        <td>@foreach($cidade as $city)
                                @if($city->id == $aeroportos->id_cidade)
                                {{ $city->nome }}
                                @endif
                                @endforeach</td>                       
                       
                              
                        <td>
                        <span class="px-3 btn btn-sm" style="background-color: #28a745;color:white">Em Funcionamento</span>
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
