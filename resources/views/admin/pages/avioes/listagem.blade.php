@extends('admin.layout.template')
@section('title', 'PDC Airline - Aviões')

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Voos
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
            <div class="border rounded">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Capacidade</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($aviao as $avioes)
                    <tr style="color: black;">
                        <td>{{$avioes->id}}</td>
                        <td> {{$avioes->modelo}}</td>
                        <td>{{$avioes->descricao}}</td>
                        <td>{{$avioes->capacidade}}</td>                        
                        <td>
                            @if($avioes->estado == '1')
                              <span class="px-3 btn btn-sm" style="background-color: #28a745;color:white">Activo</span>
                            @elseif($avioes->estado == '0')
                              <span class=" px-3 btn btn-sm" style="background-color: #fd7e14;color:white">Inactivo</span>
                            @else:
                              <span class="px-3 btn btn-sm" style="background-color: #dc3545;color:white">Cancelado</span>
                            @endif
                        </td>
                        <td>
                          <a href="{{route('avioes.show',$avioes->id)}}" class="px-3 btn  btn-info btn-sm">Ver</a>
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
