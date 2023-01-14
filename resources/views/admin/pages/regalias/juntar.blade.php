@extends('admin.layout.template')
@section('title','PDC Airlines - Criar Regalias')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Criar Regalias
        </h2>

        <!-- TABELA  -->
    
           <form action="/admin/regalia/juntar" method="POST">  
                @csrf           
                <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Tarifa</label>
                            <select name="tarifa" id="" class="form-control ">
                            @foreach($tarifa as $tarifas)
                                    <option value="{{$tarifas->id}}">{{$tarifas->nome}}</option>
                                @endforeach
                             </select>
                </div>
                <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Regalias</label>
                            <select name="regalia" id="" class="form-control ">
                            @foreach($regalia as $regalias)
                                    <option value="{{$regalias->id}}">{{$regalias->nome}}</option>
                                @endforeach
                             </select>
                        </div>
                    
                    <div class=" form-row mt-5">
                        <div class="form-group col-12 col-md-5">
                            <input type="submit" value="Cadastrar" class="w-50 btn btn-large btn-primary">
                    
                        </div>
                        </form>  
                    </div>
                   
</main>

@endsection