@extends('portal.layout.template')
@section('title','Consultar Vistos ')


@section('content')



<section class="vistos w-100 container py-3 px-5 ">
            <div class="d-flex flex-column align-items-center mt-5 mb-3">
                <h3 class="font-weight-bolder">Resultado</h3>
                <hr class="bg-danger m-0 rounded" style="width: 10%;padding: 2px;">
            </div>
           
            <div class="p-3 rounded-lg border w-100 m-auto">
                <div class="p-3 rounded-lg border w-100 m-auto">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="font-weight-bolder text-center mb-5">Visto nº: <span class="font-weight-normal">{{$visto->id}}</span> </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 ">
                            <h5 class="font-weight-bolder">Solicitante: <span class="font-weight-normal">{{$visto->nome}}</span></h5>
                            <h5 class="font-weight-bolder">Destino: <span class="font-weight-normal">{{$visto->destino}}</span></h5>
                            <h5 class="font-weight-bolder">Tipo: <span class="font-weight-normal text-capitalize">{{$visto->tipo}}</span></h5>
                        </div>
                        <div class="col-5 ">
                            <div class="m-auto">
                                    <h4 class="text-center">Estado:</h4>
                                @if($visto->estado=='pendente')
                                    <div class="p-2 text-white text-center border rounded-lg" style="background-color: orangered;">
                                        Pendente
                                    </div>
                                @elseif($visto->estado == 'aprovado')
                                    <div class="p-2 text-white text-center bg-success border rounded-lg">
                                        Aprovado
                                    </div>
                                    <div class="mt-2 text-center" style="font-size: 0.9rem;">
                                        Dirija-se a embaixada ou consulado de 
                                        <span class="font-weight-bold">{{$visto->destino}}</span>
                                        para levantar o seu visto
                                    </div>
                                @else()
                                    <div class="p-2 text-white text-center bg-danger border rounded-lg">
                                        Reprovado
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="text-center mt-4 font-weight-bold">
                <a href="{{route('visas.consult')}}" class="mr-5">Voltar a consultar</a>
                <a href="{{route('visas.code',$visto->id)}}" class="ml-5">Alterar meus dados</a>
            </div>
        </section>
            

        

@endsection