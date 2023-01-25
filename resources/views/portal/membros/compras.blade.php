@extends('portal.membros.layout')
@section('title','PDC Airlines - Meu Perfil')


@section('content')

<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">

    <div class="d-flex flex-column align-items-center mb-3 mt-5">
                <h3 class="font-weight-bolder">Meus Bilhetes</h3>
                <hr class="bg-danger m-0 rounded" style="width: 5%;padding: 2px;">
    </div>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            <div class="d-flex justify-content-start">
                  <div class="mb-2">
                    
                  </div>
            </div>
            <div class="border rounded">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Nº da compra</th>
                    <th scope="col">Nº do Bilhete</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Nº do Voo</th>
                    <th scope="col">Origem</th>
                    <th scope="col">Destino</th>
                    <th scope="col">Data</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($bilhetes as $item)
                    <tr style="color: black;">
                        <td>{{$item->id_compra}}</td>
                        <td>{{$item->id_bilhete}}</td>
                        <td>{{$item->tipo}}</td>
                        <td>{{$item->nome_cliente}} {{$item->sobrenome_cliente}}</td>
                        <td>{{$item->id_voo}}</td>
                        <td>{{$item->cidade_origem}}</td>
                        <td>{{$item->cidade_destino}}</td>
                        <td>{{$item->data_partida}} {{$item->hora }}</td>
                        <td>{{$item->estado}}</td>
                        <td class="d-flex align-items-center">
                            <a href="#" class="px-3 btn  btn-info btn-sm mr-3" role="button" 
                                data-toggle="modal" 
                                data-target="#modal{{$item->id_compra}}{{$item->id_bilhete}}{{$item->nome_cliente}}"
                                >Detalhes
                            </a>
                        </td>
                        
                    </tr>
                    <!--  MODAL DE DETALHES-->
                    <div class="modal fade" id="modal{{$item->id_compra}}{{$item->id_bilhete}}{{$item->nome_cliente}}" 
                        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Detalhes do Bilhete</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="">
                                <h5 class="" style="border-bottom: 1px solid grey;">Voo de Ida</h5>
                                <div style="color:black;" class="text-center px-2 d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 style="font-size: 0.9em;font-weight:bold;">Origem</h6>
                                        <h6 style="font-size: 0.8em;">{{$item->cidade_origem}}, {{$item->aeroporto_origem}}</h6>
                                    </div>
                                    <div>
                                        <h6 style="font-size: 0.9em;font-weight:bold;">Destino</h6>
                                        <h6 style="font-size: 0.8em;">{{$item->cidade_destino}}, {{$item->aeroporto_destino}}</h6>
                                    </div>
                                    <div>
                                        <h6 style="font-size: 0.9em;font-weight:bold;">Assento</h6>
                                        <h6 style="font-size: 0.8em;">{{$item->lugar}}</h6>
                                    </div>
                                    <div>
                                        <h6 style="font-size: 0.9em;font-weight:bold;">Estado</h6>
                                        @if($item->state == 0)
                                        <h6 style="font-size: 0.8em;" class="text-white bg-warning">Pendente</h6>
                                        @elseif($item->state == 1)
                                        <h6 style="font-size: 0.8em;" class="text-white bg-success p-1">Checkin</h6>
                                        @else
                                        <h6 style="font-size: 0.8em;" class="text-white bg-danger">Cancelado</h6>
                                        @endif
                                        
                                    </div>
                                </div>
                                @if($item->tipo_volta == "volta")
                                <h5 class="mt-3" style="border-bottom: 1px solid grey;">Voo de volta</h5>
                                <div style="color:black;" class="text-center px-2 d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 style="font-size: 0.9em;font-weight:bold;">Origem</h6>
                                        <h6 style="font-size: 0.8em;">{{$item->cidade_origem_volta}}, {{$item->aeroporto_origem_volta}}</h6>
                                    </div>
                                    <div>
                                        <h6 style="font-size: 0.9em;font-weight:bold;">Destino</h6>
                                        <h6 style="font-size: 0.8em;">{{$item->cidade_destino_volta}}, {{$item->aeroporto_destino_volta}}</h6>
                                    </div>
                                    <div>
                                        <h6 style="font-size: 0.9em;font-weight:bold;">Assento</h6>
                                        <h6 style="font-size: 0.8em;">{{$item->lugar_volta}}</h6>
                                    </div>
                                    <div>
                                        <h6 style="font-size: 0.9em;font-weight:bold;">Estado</h6>
                                        @if($item->state_volta == 0)
                                        <h6 style="font-size: 0.8em;" class="text-white bg-warning">Pendente</h6>
                                        @elseif($item->state_volta == 1)
                                        <h6 style="font-size: 0.8em;" class="text-white bg-success p-1">Checkin</h6>
                                        @else
                                        <h6 style="font-size: 0.8em;" class="text-white bg-danger">Cancelado</h6>
                                        @endif
                                        
                                    </div>
                                </div>
                                @endif
                            </div>
                          </div>
                          <div class="modal-footer">
                            <!-- <button type="submit" class="btn btn-primary">Salvar</button> -->
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            
                          </div>
                          
                        </div>
                      </div>
                    </div>
                    <!-- FIM DO MODAL DE DETALHES -->
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