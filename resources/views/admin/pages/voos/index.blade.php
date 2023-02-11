@extends('admin.layout.template')
@section('title','PDC Airlines - Lista de Voos')


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
                    <th scope="col">Origem</th>
                    <th scope="col">Destino</th>
                    <th scope="col">Data</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($voos as $voo)
                    <tr style="color: black;">
                        <td>{{$voo->id_voo}}</td>
                        <td> {{$voo->cidade_origem}}, {{$voo->aeroporto_origem}}</td>
                        <td>{{$voo->cidade_destino}}, {{$voo->aeroporto_destino}}</td>
                        <td>{{$voo->data_partida}}</td>
                        <td>{{$voo->hora}}</td>
                        <td>
                            @if($voo->estado == '1')
                              <span class="px-3 btn btn-sm" style="background-color: #28a745;color:white">Aberto</span>
                            @elseif($voo->estado == '0')
                              <span class=" px-3 btn btn-sm" style="background-color: #fd7e14;color:white">Fechado</span>
                            @elseif($voo->estado == '-1')
                              <span class=" px-3 btn btn-sm" style="background-color: #dc3545;color:white">Cancelado</span>
                            @else:
                              <span class="px-3 btn btn-sm" style="background-color: #dc3545;color:white">Não Definido</span>
                            @endif
                        </td>
                        <td class="d-flex">
                          
                          <a href="{{route('voos.show',Crypt::encryptString($voo->id_voo))}}" class="px-3 btn  btn-primary btn-sm mr-3">Ver</a>
                          <a href="{{route('voos.edit',Crypt::encryptString($voo->id_voo))}}" class="p-1 btn  btn-info btn-sm">
                            <i class="fa fa-edit"></i>
                          </a>

                        </td>
                        
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="mt-2 p-2 w-full d-flex justify-content-center">
              <div class="">
              {{ $voos->links() }}
              </div>
            </div>

        </div>


    </div>
</main>

@endsection