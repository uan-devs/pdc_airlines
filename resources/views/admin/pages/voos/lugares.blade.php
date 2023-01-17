@extends('admin.layout.template')
@section('title','PDC Airlines - Lugares')

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
                Lugares do Voo
            </h2>
        </div>

        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs">
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
                            @if($lugar->id_fila == $coluna->id)
                              <span class="mx-1 d-flex flex-column ">
                                  <span class="px-3 py-2 rounded-lg {{($lugar->estado==0)?'free':'ocupado'}} text-white"
                                      data-id="{{$lugar->id_lugar}}" style="cursor: pointer;">
                                    {{$lugar->numero}}
                                  </span>
                                  <span class="text-dark text-center" 
                                      style="font-size: 0.6em;color:black!important;font-weight:bolder">
                                      {{$lugar->tarifa}}
                                  </span>
                              </span>
                            
                            @endif
                            
                    @endforeach
                </div>
                @endforeach
                
                    
                </div>
          </div>

          <div class="mt-3">
              <a href="#" role="button" data-toggle="modal" data-target="#modalAlterarTarifa" 
              class="btn btn-primary">Alterar Tarifa</a>
          </div>
          <!--  MODAL PARA ALTERAR TARIFA -->
          <div class="modal fade" id="modalAlterarTarifa" tabindex="-1" aria-labelledby="exampleModalLabel" 
                        aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Alterar Tarifa dos lugares</h5>
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
                                <select name="tarifa" id="tarifa" class="form-control">
                                    @foreach($tarifas as $item)
                                        <option class="tarifa" data-price="{{$item->preco}}" value="{{$item->id_tarifa}}">{{$item->tarifa}}</option>
                                    @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="preco" class="col-form-label">Preço:</label>
                                <input type="number" disabled name="preco" class="form-control" id="preco">
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" id="btn-salvarTarifas" class="btn btn-primary">Salvar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            
                          </div>
                          </form>
                          
                        </div>
                      </div>
                    </div>
                    <!-- FIM DO MODAL PARA ADICIONAR TARIFA -->
        </div>
        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
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
            <span id="modal-message">{{session('error')}}</span>
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
            <span id="modal-message">{{session('success')}}</span>
      </div>
    </div>
  </div>
</div>
                       
@endif


<!-- Modal -->
<div class="modal fade" id="modalTarifaError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger font-weight-bolder " id="exampleModalLabel"style="font-size: 1.5em;" >Erro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark text-center" style="font-size: 1.2em;">
            <span id="modal-message">{{session('error')}}</span>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalTarifaSuccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success font-weight-bolder " style="font-size: 1.5em;"id="exampleModalLabel" >Sucesso!!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark text-canter" style="font-size: 1.2em;">
            <span id="modal-message">{{session('success')}}</span>
      </div>
    </div>
  </div>
</div>
@endsection