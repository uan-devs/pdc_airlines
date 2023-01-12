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
</main>

@endsection