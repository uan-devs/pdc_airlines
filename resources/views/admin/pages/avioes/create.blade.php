@extends('admin.layout.template')
@section('title','PDC Airlines - Cadastro de Aviões')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
           Cadastro de Aviões
        </h2>

        <!-- TABELA  -->
        <div class="w-full p-3 overflow-hidden bg-white rounded-lg shadow-xs">
           <form action="/admin/avioes/create" method="POST">  
                @csrf           
                    <div class="form-row mt-0">
                        
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Modelo</label>
                            <input type="text" name="modelo" required class=" form-control" id="">
                        </div>   
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Descrição</label>
                            <input type="text" name="descricao" required class=" form-control" id="">
                        </div> 
                    </div>
                    <div class="form-row mt-0">
                    
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Capacidade</label>
                            <input type="number" name="capacidade" required class=" form-control" id="">
                        </div>
                        
                    </div>    
                    <div class="form-row">
                        
                        </div>
                        <div class=" form-row mt-5">
                            <div class="form-group col-12 col-md-5">
                                <input type="submit" value="Cadastrar" class="w-50 btn btn-large btn-primary">
                        
                            </div>
                        </div> 
                </div>
                    
                    
                    
         </form>  
                        </div>
                    </div>
                   
</main>

@endsection