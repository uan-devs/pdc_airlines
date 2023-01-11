@extends('admin.layout.template')
@section('title','PDC Airlines - Lista de aeroportos')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Cadastrar aeroporto
        </h2>

        <!-- TABELA  -->
    
           <form action="/admin/aeroporto/create" method="POST">  
                @csrf           
                    <div class="form-row mt-0">
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">nome</label>
                            <input type="text" name="nome" required class=" form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Cidade</label>
                            <select name="cidade" id="" class="form-control ">
                            @foreach($cidade as $city)
                                    <option value="{{$city->id}}">{{$city->nome}}</option>
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