@extends('admin.layout.template')
@section('title','PDC Airlines - Lista de Voos')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Editar Tarifa do voo 
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
        <form class="form" action="{{route('voos.update_tarifa')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_tarifa" value="{{$tarifa->id_tarifa}}">
                    <h6 class="mb-3 font-weight-bold">Dados da Tarifa</h6>
                    <div class="form-row">
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Nome</label>
                            <input class="form-control" type="text" name="" value="{{$tarifa->tarifa}}" id="" disabled>
                        </div>
                        
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Classe</label>
                            <input class="form-control" type="text" disabled name="" id="" value="{{$tarifa->classe}}" disable>
                        </div>
                        <div class="form-group col-12 col-md-3">
                                <label for="">Preço</label>
                                <input class="form-control" type="number" name="preco" id="" requi\ value="{{$tarifa->preco}}">
                        </div>
                                
                    </div>
                    <div class="form-row mt-0">
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Taxa de Retorno (%)</label>
                            <input class="form-control" type="number" name="taxa" required value="{{$tarifa->taxa_retorno}}" class=" form-control" id="">
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