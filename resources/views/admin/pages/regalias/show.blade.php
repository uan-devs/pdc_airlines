@extends('admin.layout.template')
@section('title', 'PDC Airline - aeroporto')

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Listagem de Tarifa e Regalia 
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
            <div class="border rounded">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                   
                    <th scope="col">Regalia</th>
                    <th scope="col">Tarifa</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($regaliast as $regaliat)
                  <tr style="color: black;">
                  
                          <td>{{$loop->index + 1}}</td>  
                          <td>{{$regaliat->regalia}} </td>
                          <td> {{$regaliat->tarifa}}</td>
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
