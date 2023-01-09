@extends('admin.layout.template')
@section('title','PDC Airlines - Lista de Voos')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Cadastrar voo
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
        <form class="form" action="{{route('voos.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h6 class="mb-3 font-weight-bold">Dados do Voo</h6>
                    <div class="form-row">
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Origem</label>
                            <select name="origem" id="" class="form-control ">
                                @foreach($aeroportos as $item)
                                    <option value="{{$item->id}}">{{$item->cidade}}, {{$item->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Destino</label>
                            <select name="destino" id="" class="form-control ">
                                @foreach($aeroportos as $item)
                                    <option value="{{$item->id}}">{{$item->cidade}}, {{$item->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-3">
                                <label for="">Avião</label>
                                <select name="aviao" id="" class="form-control ">
                                    @foreach($avioes as $item)
                                        <option value="{{$item->id}}">{{$item->id}}- {{$item->modelo}}, {{$item->tipo}}</option>
                                    @endforeach
                                </select>
                        </div>
                                
                    </div>
                    <div class="form-row mt-0">
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Data</label>
                            <input type="date" name="data" required class=" form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Hora</label>
                            <input type="time" name="hora" required class=" form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 ">
                            <label for="">Duaração Aproximada(horas)</label>
                            <input type="number" name="duracao" class=" form-control" id="">
                        </div>
                        
                    </div>
                    <div class="form-row">
                        
                    </div>
                    <div class=" form-row mt-5">
                        <div class="form-group col-12 col-md-5">
                            <input type="submit" value="Cadastrar" class="w-50 btn btn-large btn-primary">
                    
                        </div>
                    </div>
                </form>
           

        </div>


    </div>
</main>

@endsection