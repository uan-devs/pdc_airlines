@extends('admin.layout.template')
@section('title','PDC Airlines - Lista de Voos')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Editar voo nº {{$voo->id}}
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
        <form class="form" action="{{route('voos.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="idVoo" value="{{base64_encode($voo->id)}}">
                    <h6 class="mb-3 font-weight-bold">Dados do Voo</h6>
                    <div class="form-row">
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Origem</label>
                            <select name="origem" id="" class="form-control " disabled>
                                @foreach($aeroportos as $item)
                                    @if($voo->id_aeroporto_origem == $item->id)
                                    <option value="{{$item->id}}" selected>{{$item->cidade}}, {{$item->nome}}</option>
                                    @else
                                    <option value="{{$item->id}}">{{$item->cidade}}, {{$item->nome}}</option>
                                    @endif
                                    
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Destino</label>
                            <select name="destino" id="" class="form-control " disabled>
                                @foreach($aeroportos as $item)
                                    @if($voo->id_aeroporto_destino == $item->id)
                                    <option value="{{$item->id}}" selected>{{$item->cidade}}, {{$item->nome}}</option>
                                    @else
                                    <option value="{{$item->id}}">{{$item->cidade}}, {{$item->nome}}</option>
                                    @endif    
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-3">
                                <label for="">Avião</label>
                                <select name="aviao" id="" class="form-control ">
                                    @foreach($avioes as $item)
                                        @if($voo->id_aviao == $item->id)
                                        <option value="{{$item->id}}" selected>{{$item->id}}- {{$item->modelo}}</option>
                                        @else
                                        <option value="{{$item->id}}">{{$item->id}}- {{$item->modelo}}</option>
                                        @endif
                                        
                                    @endforeach
                                </select>
                        </div>
                                
                    </div>
                    <div class="form-row mt-0">
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Data</label>
                            <input type="date" name="nova_data" required value="{{$voo->data_partida}}" class=" form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Hora</label>
                            <input type="time" name="nova_hora" required value="{{$voo->hora}}" class=" form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 ">
                            <label for="">Duração Aproximada(horas)</label>
                            <input type="number" name="nova_duracao" class=" form-control" id="" value="{{$voo->duracao_estimada}}">
                        </div>
                        
                    </div>
                    <div class="form-row">
                        
                    </div>
                    <div class=" form-row mt-5">
                        <div class="form-group col-12 col-md-5">
                            <input type="submit" value="Guardar" class="w-50 btn btn-large btn-primary">
                            
                        </div>

                        
                    </div>
                </form>
           

        </div>


    </div>
</main>

@endsection