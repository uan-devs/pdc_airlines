@extends('admin.layout.template')
@section('title','PDC Airlines - Lista de aeroportos')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Criar Escala
        </h2>

        <!-- TABELA  -->
    
           <form action="/admin/escala/create" method="POST">  
                @csrf           
                    <div class="form-row mt-0">
                    <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Aeroporto</label>
                            <select name="aeroporto" id="" class="form-control ">
                            @foreach($aeroporto as $aeroportos)
                                    <option value="{{$aeroportos->id}}">{{$aeroportos->nome}}</option>
                                @endforeach
                             </select>
                        </div>
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Voo</label>
                            <select name="voo" id="" class="form-control ">
                            @foreach($voo as $voos)
                                    <option value="{{$voos->id}}">{{$voos->id}}</option>
                                @endforeach
                             </select>
                        </div>
                    </div>
                    
                    
                    <div class=" form-row mt-5">
                        <div class="form-group col-12 col-md-5">
                            <input type="submit" value="Cadastrar" class="w-50 btn btn-large btn-primary">
                    
                        </div>
                        </form>  
                    </div>
                   
</main>

@endsection