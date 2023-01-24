@extends('admin.layout.template')
@section('title','PDC Airlines - Lista de Tarifas')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Tarifas
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            <div class="p-2 d-flex justify-content-between align-items">
              <div>
                <a href="#" role="button" data-toggle="modal" data-target="#modalNovaTarifa"  
                class="btn btn-primary">Nova Tarifa</a>
              </div>
              <div>
                <a href="#"role="button" data-toggle="modal" data-target="#modalClasses"  
                class="btn btn-success">Lista de Classes</a>
                <a href="#"role="button" data-toggle="modal" data-target="#modalNovaClasse"  
                class="btn btn-primary">Nova Classe</a>
              </div>
            </div>
            <div class="border rounded">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tarifa</th>
                    <th scope="col">Classe</th>
                    <th>Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($tarifas as $item)
                    <tr style="color: black;">
                        <td>{{$item->id}}</td>
                        <td>{{$item->tarifa}}</td>
                        <td>{{$item->classe}}</td>
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
                          <form method="post" action="{{route('tarifas.create')}}">
                            @csrf
                          <div class="modal-body">
                              <div class="form-group">
                                <label for="tarifa" class="col-form-label">Tarifa:</label>
                                <input type="text" name="tarifa" class="form-control" id="tarifa">
                              </div>

                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Selecione a classe:</label>
                                <select name="id_classe" id="" class="form-control">
                                    @foreach($classes as $item)
                                        <option value="{{$item->id}}" style="text-transform:capitalize">{{$item->nome}}</option>
                                    @endforeach
                                </select>
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

<!--  MODAL PARA CLASSES -->
<div class="modal fade" id="modalClasses" tabindex="-1" aria-labelledby="exampleModalLabel" 
                        aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Lista de Classes</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="{{route('voos.addTarifa')}}">
                            @csrf
                          <div class="modal-body">
                          <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome da Classe</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($classes as $item)
                    <tr style="color: black;">
                        <td>{{$item->id}}</td>
                        <td> {{$item->nome}}</td>
                        
                    </tr>
                  @endforeach
                </tbody>
              </table>
                            
                          </div>
                          <div class="modal-footer">
                            
                          </div>
                          </form>
                          
                        </div>
                      </div>
                    </div>
                    <!-- FIM DO MODAL CLASSES -->

                     <!--  MODAL PARA ADICIONAR CLASSE -->
     <div class="modal fade" id="modalNovaClasse" tabindex="-1" aria-labelledby="exampleModalLabel" 
                        aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar Classe</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="{{route('classes.create')}}">
                            @csrf
                          <div class="modal-body">
                              <div class="form-group">
                                <label for="classe" class="col-form-label">Classe:</label>
                                <input type="text" name="classe" class="form-control" id="classe">
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
                    <!-- FIM DO MODAL PARA ADICIONAR CLASSE -->

</main>

@endsection