@extends('portal.membros.layout')
@section('title','PDC Airlines - Meu Perfil')


@section('content')


<section class="container mt-5">
            <div class="d-flex flex-column align-items-center mb-3 mt-2">
                <h3 class="font-weight-bolder">Meus Dados</h3>
                <hr class="bg-danger m-0 rounded" style="width: 5%;padding: 2px;">
            </div>

            <div class="p-3 rounded-lg border ">
                <div>
                    <!-- @if(session('error'))

                        <div class="alert alert-danger " role="alert">
                            {{session('error')}}
                        </div>
                    @endif -->
                </div>
                <div>
                    @if(session('sucess'))
                        <div class="alert alert-success " role="alert">
                            {{session('sucess')}}
                        </div>
                    @endif
                </div>
                <div>
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach($errors->all() as $error)
                                <p class="text-danger font-weight-bolder">{{$error}}</p>
                            @endforeach
                        </div>
                        @endif
                   
                </div>
                <div class="milhas d-flex justify-content-end">
                    <div>
                        <h6 class="btn btn-info">Milhas: {{$membro->milhas}} <i class="fas fa-star text-warning"></i> </h6>
                    </div>
                </div>
                <form class="form" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <h6 class="font-weight-bold mb-3 mt-5">Dados Pessoais</h6>
                    <!-- <div class="form-row mt-0">
                        <div class="form-group col-12 col-md-4 mr-5">
                            <label for="">Nº de Bilhete</label>
                            <input type="text" id="bilhetes" onkeyup="validarBi()" name="bilhete" 
                            required class=" form-control" id="" placeholder="Ex: 006264121LA047">
                            <label id="vBi"></label>
                        </div>
                        <div class="form-group col-12 col-md-4 mr-5">
                            <label for="">Nº do Passaporte</label>
                            <input type="text" onkeyup="validarPassaPorte()"  name="passaporte" 
                            placeholder=""
                            required class=" form-control" id="pass">
                            <label id="vPass"></label>
                        </div>
                        
                    </div> -->

                    <div class="form-row mt-4">
                        <div class="form-group col-12 col-md-2 mr-2 ">
                            <label id="labell" for="">Titulo</label>
                            <input type="text" name="titulo" 
                            placeholder="Seu titulo"
                            required class="f form-control" id="name" value="{{$membro->titulo}}">
                            <label id="vNome"></label>
                        </div>
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label id="labell" for="">Nome</label>
                            <input type="text" name="nome" 
                            placeholder="Seu nome completo"
                            required class="f form-control" id="name" value="{{$membro->nome}}">
                            <label id="vNome"></label>
                        </div>
                        <div class="form-group col-12 col-md-3 ">
                            <label id="labell" for="">Sobrenome</label>
                            <input type="text" name="sobrenome" 
                            placeholder="Seu sobrenome"
                            required class="f form-control" id="sobrenome" value="{{$membro->sobrenome}}">
                            <label id="vNome"></label>
                        </div>
                        <div class="form-group col-12 col-md-3 ">
                            <label id="labell" for="">Data de Nascimento</label>
                            <input type="date" name="data"
                            required class="f form-control" id="data" value="{{$membro->data}}">
                            <label id="vNome"></label>
                        </div>
                        
                    </div>

                    <div class="form-row mt-4">
                        <div class="form-group col-12 col-md-2 mr-2">
                            <label id="labell" for="">Genero</label>
                            <input type="text" name="genero" 
                            placeholder="Seu Genero"
                            required class="f form-control" id="genero" value="{{$membro->genero}}">
                            <label id="vNome"></label>
                        </div>
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Endereço</label>
                            <input type="text" id="endereco" required class="form-control " 
                            name="endereco" id="" value="{{$membro->morada}}">
                            <label id="vData"></label>
                        </div>

                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Idioma</label>
                            <input type="text" id="idioma" required class="form-control " 
                            name="idioma" id="" value="{{$membro->idioma}}">
                        </div>
                        
                    </div>
                   
                   

                    
                    <label id="filesInfo"></label>
                    <div class=" form-row mt-2">
                        <div class="form-group col-12 col-md-5">
                            <input type="submit" value="Salvar" id="salvar"  class="w-50 btn btn-large btn-danger">
                        </div>
                    </div>
                </form>
            </div>
        </section>
@endsection