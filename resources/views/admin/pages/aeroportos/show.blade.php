@extends('admin.layout.template')
@section('title', 'PDC Airline - Voo')

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-0 mx-auto">
            <div class="">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
                        Lista de aeroportos
                    </h2>

                </div>

                <div class="mt-3">
                    <div class="border rounded ">
                        <table class="table">
                            <thead class="thead-dark justify-right">
                                <tr>
                                    <th scope="col">#</th>

                                    <th scope="col">Nome</th>
                                    <th scope="col">Cidade</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($aeroporto as $aeroportos)
                                <tr>
                                    <td>#</td>
                                    <td>{{ $aeroportos->nome }}</td>
                                    <td>@foreach($cidade as $city)
                                @if($city->id == $aeroportos->id_cidade)
                                {{ $city->nome }}
                                @endif
                                @endforeach</td>
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
