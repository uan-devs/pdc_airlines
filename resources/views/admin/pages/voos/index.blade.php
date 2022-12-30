@extends('admin.layout.template')
@section('title','Visa - Vistos')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Voos
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
            <div class="border rounded">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Origem</th>
                    <th scope="col">Destino</th>
                    <th scope="col">Data</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($voos as $voo):
                    <tr>
                        <td>{{$voo->id_flight}}</td>
                        <td> {{$voo->origin_city}}, {{$voo->origin_airport}}</td>
                        <td>{{$voo->destiny_city}}, {{$voo->destiny_airport}}</td>
                        <td>{{$voo->date_}}</td>
                        <td>{{$voo->time_}}</td>
                        <td>
                            @if($voo->state):
                              <span class="btn btn-small btn-success">Activo</span>
                            @else:
                              <span class="btn btn-small btn-danger">Cancelado</span>
                            @endif
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
</main>

@endsection