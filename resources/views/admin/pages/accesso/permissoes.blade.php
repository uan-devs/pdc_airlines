@extends('admin.layout.template')
@section('title','Visa - Permissões')


@section('content')


<main class="h-100 pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto h-100">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Todas as Permissoes
        </h2>

       <!-- TABELA  -->
        <div class="w-100 h-100 d-block shadow-xs bg-white rounded p-4 ">
            <div class="d-flex justify-content-between align-items mb-3">
                <!-- <div>
                    <a href="#" class="btn btn-success">Ver todas permissões</a>
                </div> -->
                <div class=" ">
                  <a href="#" class="btn btn-primary" role="button" data-toggle="modal" data-target="#modalNovaPermissao">Nova Permissão</a>
                </div>    
            </div>
            
            <div class="border">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Permissão</th>
                    <th scope="col">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($permissoes as $item)
                  <tr>
                    <td scope="row">#</td>
                    <td scope="row">{{$item->nome}}</td>
                    <td class="d-flex align-items-center">
                      <!-- <a href="{{route('papeis.permissoes',$item->id)}}" class="mr-5 btn btn-primary btn-sm">
                        Ver permissões
                      </a> -->
                      <div class="flex items-center space-x-1 text-sm">
                            <a href="#"
                            class="text-primary mr-2"
                            aria-label="Edit"
                            >
                                <i class="fa fa-pen"></i>
                            </a>
                            <a href="#"
                            class="text-danger"
                            aria-label="Edit"
                            >
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                
                    
                    </td>
                  </tr>
                  @endforeach

                </tbody>
              </table>
            </div>
        </div>


    </div>
</main>

<!--  MODAL PARA ADICIONAR TARIFA -->
<div class="modal fade" id="modalNovaPermissao" tabindex="-1" aria-labelledby="exampleModalLabel" 
                        aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nova Permissão</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="{{route('permissoes.store')}}">
                            @csrf
                            
                          <div class="modal-body">
                            
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Permissão:</label>
                                
                                <input type="text" name="permissao" class="form-control" id="">
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

@endsection