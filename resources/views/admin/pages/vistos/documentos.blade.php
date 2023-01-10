@extends('admin.layout.template')
@section('title','Visa - Vistos')


@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h3>Visto solicitado</h3>
        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            <div class="row font-weight-bold">
                <div class="col-4">
                    <h6 class="font-weight-bold">Requerente: <span class="text-primary">{{$visto->nome}}</span></h6>
                </div>
                <div class="col-4">
                    <h6 class="font-weight-bolder">Tipo de Visto: <span class="text-primary text-capitalize">{{$visto->tipo}}</span></h6>
                </div>
                <div class="col-4">
                    <h6 class="font-weight-bolder">Destino: <span class="text-primary">{{$visto->destino}}</span></h6>
                </div>
            </div>
            <div class="row font-weight-bold">
                <div class="col-4 mt-2">
                    <h6 class="font-weight-bold">Estado: <span class="text-capitalize text-white bg-success py-1 px-2 rounded-lg">{{$visto->estado}}</span></h6>
                </div>
            </div>
        </div>

        <!-- TABELA  -->
        <div class="w-full p-4 overflow-hidden bg-white rounded-lg shadow-xs">
            <h5 class="mb-3">Documentos carregados</h5>
            <div class="border rounded">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Documento</th>
                    <th scope="col">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($documentos as $doc)
                  <tr>
                    <td class="text-capitalize">{{$doc->nome}}</td>
                    <td>
                      <div class="">
                            <a href="{{asset($doc->ficheiro) }}"
                            class="text-primary"
                            >
                                <i class="fa fa-eye"></i>
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