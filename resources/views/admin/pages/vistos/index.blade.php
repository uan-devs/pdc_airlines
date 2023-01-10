@extends('admin.layout.template')
@section('title','Visa - Vistos')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Vistos
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
            <div class="border rounded">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Requerente</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Solicitado Em</th>
                    <th scope="col">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($vistos as $visto)
                  <tr>
                    <th scope="row">{{$visto->id}}</th>
                    <td class="text-capitalize">{{$visto->tipo}}</td>
                    <td>{{$visto->nome}}</td>
                    <td class="text-capitalize">{{$visto->estado}}</td>
                    <td>{{$visto->created_at}}</td>
                    <td>
                      <div class="">
                          <a href="{{route('vistos.docs', $visto->id )}}" class="mr-3">
                            Ver documentos
                          </a>
                            <a href="{{route('vistos.answer.create',$visto->id)}}" class="btn btn-success btn-sm mr-3">
                                Responder
                            </a>
                            <a href="#"
                            class="text-danger"
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
            <div class="mt-2 p-2 w-full d-flex justify-content-center">
              <div class="">
                {{$vistos->links()}}
              </div>
            </div>

        </div>


    </div>
</main>

@endsection