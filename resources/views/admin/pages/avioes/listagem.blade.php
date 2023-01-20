@extends('admin.layout.template')
@section('title', 'PDC Airline - Aviões')

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-0 mx-auto">
            <div class="">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
                        Detalhes do Avião
                    </h2>

                </div>

                <div class="mt-3">
                    <div class="border rounded ">
                        <table class="table">
                            <thead class="thead-dark justify-right">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Capacidade</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        
    @foreach($aviao as $avioes)
           
        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs ">
                <div class="row font-weight-bold">
                    <div class="col-4">
                        <h6 class="font-weight-bolder">id: <span
                                class="text-primary text-capitalize">{{ $avioes->id }}</span></h6>
                    </div>
                    <div class="col-4">
                        <h6 class="font-weight-bolder">Modelo: <span
                                class="text-primary text-capitalize">{{ $avioes->modelo }}</span></h6>
                    </div>
                    <div class="col-4">
                        <h6 class="font-weight-bolder">Descrição: <span
                                class="text-primary text-capitalize">{{ $avioes->descricao }}</span></h6>
                    </div>
                   <div class="col-4">
                        <h6 class="font-weight-bolder">Capacidade: <span
                                class="text-primary text-capitalize">{{ $avioes->capacidade }}</span></h6>
                    </div>
                </div>

        </div>
            
    @endforeach
    

    </main>



@endsection
