@extends('admin.layout.template')
@section('title',"PDC Airline - Voo")

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
                Detalhes do Aviao
            </h2>
            
        </div>

        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            <div class="row font-weight-bold">
                <div class="col-4">
                    <h6 class="font-weight-bold">Aviao Nº: <span class="text-primary">{{$aviao->id}}</span></h6>
                </div>
                <div class="col-4">
                    <h6 class="font-weight-bolder">Tipo: <span class="text-primary text-capitalize">{{$aviao->tipo}}</span></h6>
                </div>
                <div class="col-4">
                    <h6 class="font-weight-bolder">Modelo: <span class="text-primary">{{$aviao->modelo}}</span></h6>
                </div>
            </div>
            <div class="row font-weight-bold mb-3">
                <div class="col-4">
                    <h6 class="font-weight-bold">Capacidade: <span class="text-primary">{{$aviao->capacidade}}</span></h6>
                </div>
                <div class="col-4">
                    @if($aviao->estado=='1')
                    <h6 class="font-weight-bold">Estado: <span class="text-capitalize text-white bg-success py-1 px-2 rounded-lg">Em Funcionamento</span></h6>
                    @elseif($aviao->estado == '0')
                    <h6 class="font-weight-bold">Estado: <span class="text-capitalize text-white bg-warning py-1 px-2 rounded-lg">Parado</span></h6>
                    @else()
                    <h6 class="font-weight-bold">Estado: <span class="text-capitalize text-white bg-danger py-1 px-2 rounded-lg">Cancelado</span></h6>
                    @endif
                </div>
            </div>

            
            


        </div>
        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
        <div class="">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="">Lugares do Aviao</h5>
                    <div>
                        <!-- Button trigger Modal de Tarifa -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalNovaTarifa">
                            Adicionar Fileira
                        </button>
                    </div>

                    <!--  MODAL PARA ADICIONAR TARIFA -->
                    <div class="modal fade" id="modalNovaTarifa" tabindex="-1" aria-labelledby="exampleModalLabel" 
                        aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar fila</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="{{route('voos.addTarifa')}}">
                            @csrf
                            <input type="hidden" name="id_voo" value="{{$aviao->id}}">
                          <div class="modal-body">
                            
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Identificador da fila:</label>
                                <select name="fila" id="" class="form-control">
                                    
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="preco" class="col-form-label">Quantidade de lugares na fila:</label>
                                <input type="number" name="qtd" class="form-control" id="preco">
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
                <div class="w-100 border " 
                style="border-width: 5px !important; min-height:55vh;background-image:url('img/plane2.jpg');background-position: center;background-size: 250%;background-repeat: no-repeat;"
            >
                <div class="p-3 places w-100 bg-white border" style="height: 35vh; margin-top:6%; overflow:scroll" >
                

                @foreach($colunas as $coluna)
                <div class="d-flex justify-content-start align-items-center no-wrap mb-3">
                    <h4 class="mr-3 bolder text-dark border-right border-dark px-2" 
                            style="border-width: 4px!important;">
                            {{$coluna->identificador}}
                    </h4>
                    @foreach($lugares as $lugar)
                            @if($lugar->id_coluna == $coluna->id)
                              <span class="mx-2 d-flex flex-column ">
                                <span class="px-2 py-1 rounded-lg bg-primary {{($lugar->in_janela==1)?'janela':' '}} text-white text-center"
                                      data-id="{{$lugar->id}}" style="min-width:50px !important;cursor: pointer;">
                                    {{$lugar->numero}}
                                </span>
                              </span>
                            
                            @endif
                            
                    @endforeach
                </div>
                @endforeach
                
                    
                </div>
          </div>

                </div>
                <div class="mt-2 ml-2 d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                      <div class="mr-2" style="background-color: #20c997;width:15px !important;height: 15px !important;"></div>
                      <div>Lugar a janela</div>
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