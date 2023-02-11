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
                                    <th scope="col">Acções</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($aviao as $avioes)
                                <tr>
                                    <td>#</td>
                                    <td>{{ $avioes->modelo }}</td>
                                    <td>{{ $avioes->descricao }}</td>
                                    <td>{{ $avioes->capacidade }}</td>
                                    <td>
                                        @if($avioes->estado == 1)
                                            <span class="btn btn-sm btn-success">Em funcionamento</span>
                                        @else
                                            <span class="btn btn-sm btn-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('avioes.show',Crypt::encryptString($avioes->id) )}}" class="btn btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        
   
    

    </main>



@endsection
