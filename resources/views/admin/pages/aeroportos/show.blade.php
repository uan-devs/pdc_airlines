@extends('admin.layout.template')
@section('title', 'PDC Airline - Voo')

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-0 mx-auto">
            <div class="">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
                        Detalhes do aeroporto
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
                        </table>
                    </div>
                </div>
            </div>

        </div>
        
    @foreach($aeroporto as $aeroportos)
           
        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs ">
                <div class="row font-weight-bold">
                    <div class="col-4">
                        <h6 class="font-weight-bolder">Nome: <span
                                class="text-primary text-capitalize">{{ $aeroportos->nome }}</span></h6>
                    </div>
                    <div class="col-4">
                        <h6 class="font-weight-bolder">Cidade: <span
                                class="text-primary text-capitalize">
                                @foreach($cidade as $city)
                                @if($city->id == $aeroportos->id_cidade)
                                {{ $city->nome }}
                                @endif
                                @endforeach
                            </span></h6>
                    </div>
                </div>

        </div>
            
    @endforeach
    

    </main>



@endsection
