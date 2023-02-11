@extends('admin.layout.template')
@section('title',"PDC Airline - Voo")

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
                Detalhes do Voo
            </h2>
            <div>
                @if($voo->estado != '0')
                <a href="{{route('voos.lugares',Crypt::encryptString($voo->id_voo))}}" class="btn btn-info">Lugares do Voo</a>
                @endif
                @if($voo->estado == '0')
                <a href="{{route('voos.activate',$voo->id_voo)}}" class="btn btn-success">Abrir Voo</a>
                @elseif($voo->estado == '1')
                <a href="#" role="button"data-toggle="modal" data-target="#modalCancelarVoo" class="btn btn-danger">Cancelar Voo</a>
                @endif
                
            </div>
        </div>
                  <!-- Modal Cancelar Voo -->
          <div class="modal fade" id="modalCancelarVoo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title text-danger font-weight-bolder " id="exampleModalLabel"style="font-size: 1.5em;" >Cancelar Voo</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-dark text-center" style="font-size: 1.2em;">
                        <div>
                          <h4>Deseja Cancelar o Voo <span style="font-weight: bolder;">{{$voo->id_voo}}</span> ?</h4>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                          <a href="{{route('voos.cancel',$voo->id_voo)}}" class="btn btn-primary mr-2">Sim</a>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                        </div>
                </div>
              </div>
            </div>
          </div>

        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            <div class="row font-weight-bold">
                <div class="col-4">
                    <h6 class="font-weight-bold">Voo Nº: <span class="text-primary">{{$voo->id_voo}}</span></h6>
                </div>
                <div class="col-4">
                    <h6 class="font-weight-bolder">Origem: <span class="text-primary text-capitalize">{{$voo->cidade_origem}}, {{$voo->aeroporto_origem}}</span></h6>
                </div>
                <div class="col-4">
                    <h6 class="font-weight-bolder">Destino: <span class="text-primary">{{$voo->cidade_destino}}, {{$voo->aeroporto_destino}}</span></h6>
                </div>
            </div>
            <div class="row font-weight-bold mb-3">
                <div class="col-4">
                    <h6 class="font-weight-bold">Data do Voo: <span class="text-primary">{{$voo->data_partida}}</span></h6>
                </div>
                <div class="col-4">
                    <h6 class="font-weight-bolder">Hora de Partida: <span class="text-primary text-capitalize">{{$voo->hora}}</span></h6>
                </div>
                <div class="col-4">
                    @if($voo->estado=='1')
                    <h6 class="font-weight-bold">Estado: <span class="text-capitalize text-white bg-success py-1 px-2 rounded-lg">Aberto</span></h6>
                    @elseif($voo->estado == '0')
                    <h6 class="font-weight-bold">Estado: <span class="text-capitalize text-white bg-warning py-1 px-2 rounded-lg">Fechado</span></h6>
                    @else()
                    <h6 class="font-weight-bold">Estado: <span class="text-capitalize text-white bg-danger py-1 px-2 rounded-lg">Cancelado</span></h6>
                    @endif
                </div>
            </div>

            
            


        </div>
        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
        <div class="">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="">Tarifas do Voo</h5>
                    <div>
                        <!-- Button trigger Modal de Tarifa -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalNovaTarifa">
                            Adicionar Tarifa
                        </button>
                    </div>

                    <!--  MODAL PARA ADICIONAR TARIFA -->
                    <div class="modal fade" id="modalNovaTarifa" tabindex="-1" aria-labelledby="exampleModalLabel" 
                        aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar Tarifa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="{{route('voos.addTarifa')}}">
                            @csrf
                            <input type="hidden" name="id_voo" value="{{$voo->id_voo}}">
                          <div class="modal-body">
                            
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tarifa:</label>
                                <select name="tarifa" id="" class="form-control">
                                    @foreach($outrasTarifas as $item)
                                        <option value="{{$item->id_tarifa}}">{{$item->tarifa}}</option>
                                    @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="preco" class="col-form-label">Preço:</label>
                                <input type="number" name="preco" class="form-control" id="preco">
                              </div>
                              <div class="form-group">
                                <label for="preco" class="col-form-label">Taxa de Ida e Volta:</label>
                                <input type="number" name="taxa" class="form-control" id="preco">
                              </div>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            
                          </div>
                          </form>
                          
                        </div>
                      </div>
                    </div>
                    <!-- FIM DO MODAL PARA ADICIONAR TARIFA -->
                </div>

                <div class="mt-3">
                <div class="border rounded">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Classe</th>
                    <th scope="col">Tarifa</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Taxa de Retorno</th>
                    <th scope="col">Lugares Disponiveis</th>
                    <th scope="col">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($tarifas as $item)
                    <tr style="color: black;">
                        <td>{{$item->id_tarifa}}</td>
                        <td> {{$item->classe}}</td>
                        <td>{{$item->tarifa}}</td>
                        <td>{{$item->preco}}</td>
                        <td>{{$item->taxa_retorno}}%</td>
                        <td>0 </td>
                        <td>
                          <a href="{{route('voos.show',$voo->id_voo)}}" class=" btn  btn-info btn-sm">Editar</a>
                          <a href="{{route('voos.show',$voo->id_voo)}}" class=" btn  btn-danger btn-sm">Remover</a>
                        </td>
                        
                    </tr>
                  @endforeach
                </tbody>
              </table>
                </div>
                </div>
            </div>
            
        </div>



    </div>
</main>


<!-- MODAL PARA STATUS DE OPERALÇÃO -->
@if(session('error'))
<!-- Modal -->
<div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger font-weight-bolder " id="exampleModalLabel"style="font-size: 1.5em;" >Erro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark text-center" style="font-size: 1.2em;">
            {{session('error')}}
      </div>
    </div>
  </div>
</div>
                       
@endif

@if(session('success'))
<!-- Modal -->
<div class="modal fade" id="modalSuccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success font-weight-bolder " style="font-size: 1.5em;"id="exampleModalLabel" >Sucesso!!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark text-canter" style="font-size: 1.2em;">
            {{session('success')}}
      </div>
    </div>
  </div>
</div>
                       
@endif


@endsection