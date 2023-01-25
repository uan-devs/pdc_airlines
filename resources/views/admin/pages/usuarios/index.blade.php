@extends('admin.layout.template')
@section('title','Visa - Utilizadores')


@section('content')


<main class="h-100 pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto h-100">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Utilizadores
        </h2>

       <!-- TABELA  -->
        <div class="w-100 h-100 d-block shadow-xs bg-white rounded p-4 ">
            
        
            

            <div class="border">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Permissões</th>
                    <th scope="col">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                  <tr>
                    <th scope="row">
                      #
                      <!-- {{$user->id}}  -->
                      <!-- <i class="fa fa-user"></i> -->
                    </th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                      <a href="{{route('users.permissoes',base64_encode($user->id))}}">
                        Ver permissões
                      </a>
                    </td>
                    <td>
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

@endsection