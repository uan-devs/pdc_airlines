@extends('admin.layout.template')
@section('title','Visa - Papeis e permissões')


@section('content')


<main class="h-100 pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto h-100">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Papeis e permissões
        </h2>

       <!-- TABELA  -->
        <div class="w-100 h-100 d-block shadow-xs bg-white rounded p-4 ">
            <div class="d-flex justify-content-between align-items mb-3">
                <div>
                    <a href="{{route('permissoes')}}" class="btn btn-success">Ver todas permissões</a>
                </div>
                <div class=" ">
                  <a href="#" class="btn btn-primary" role="button" data-toggle="modal" data-target="#modalNovoPapel">Novo Papel</a>
                </div>    
            </div>
            
            <div class="border">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Papel</th>
                    <th scope="col">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($papeis as $item)
                  <tr>
                    <td scope="row">#</td>
                    <td scope="row">{{$item->papel}}</td>
                    <td class="d-flex align-items-center">
                      <a href="{{route('papeis.permissoes',base64_encode($item->id))}}?id={{$item->id}}&papel={{$item->papel}}" class="mr-5 btn btn-primary btn-sm">
                        Ver permissões
                      </a>
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
<div class="modal fade" id="modalNovoPapel" tabindex="-1" aria-labelledby="exampleModalLabel" 
                        aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar Papel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="{{route('papeis.store')}}">
                            @csrf
                          <div class="modal-body">
                            
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Papel:</label>
                                <input type="text" name="nome" id=""  class="form-control" placeholder="Nome do Papel">
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