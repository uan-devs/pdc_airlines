@extends('admin.layout.template')
@section('title','PDC Airlines - Lista de Tarifas')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Regalias da Tarifa "{{$tarifa->nome}}"
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            <div class="p-2 d-flex justify-content-between align-items">
              <div>
                <a href="#" role="button" data-toggle="modal" data-target="#modalNovaRegalia"  
                class="btn btn-primary">Atribuir Nova Regalia</a>
              </div>
              <div>
                <!-- <a href="#"role="button" data-toggle="modal" data-target="#modalClasses"  
                class="btn btn-success">Lista de Classes</a>
                <a href="#"role="button" data-toggle="modal" data-target="#modalNovaClasse"  
                class="btn btn-primary">Nova Classe</a> -->
              </div>
            </div>
            <div class="border rounded">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Regalia</th>
                    <th>Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($regalias as $item)
                    <tr style="color: black;">
                        <td>{{$item->id}}</td>
                        <td>{{$item->nome}}</td>
                        <td>
                          <a href="#" class="px-3 btn  btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                          </a>
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


                     <!--  MODAL PARA ADICIONAR CLASSE -->
     <div class="modal fade" id="modalNovaRegalia" tabindex="-1" aria-labelledby="exampleModalLabel" 
                        aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar Regalia</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="{{route('regalias.atribuir')}}">
                            @csrf
                            <input type="hidden" name="id_tarifa" value="{{$id_tarifa}}">
                          <div class="modal-body">
                              <div class="form-group">
                                <label for="regalia" class="col-form-label">Regalia:</label>
                                <select name="regalia" id="" class="form-control">
                                    @foreach($todasregalias as $item)
                                        <option value="{{$item->id}}">{{$item->nome}}</option>
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
                    <!-- FIM DO MODAL PARA ADICIONAR CLASSE -->

</main>

@endsection