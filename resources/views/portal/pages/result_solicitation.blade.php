@extends('portal.layout.template')
@section('title','Consultar Vistos ')


@section('content')



<section class="vistos w-100 container py-3 px-5 ">
            <div class="d-flex flex-column align-items-center mt-5 mb-3">
                <h3 class="font-weight-bolder">Resultado</h3>
                <hr class="bg-danger m-0 rounded" style="width: 10%;padding: 2px;">
            </div>
           
            <div class="p-3 rounded-lg border w-50 m-auto">
                <div class="p-3 rounded-lg border w-100 m-auto">
                    <div class="row">
                        <div class="col-12">
                            <i class=""></i>
                            <h3 class="text-success font-weight-bolder text-center mb-2">Parabéns:  </h3>
                            <p class=" text-center mb-5">O seu visto foi solicitado com sucesso</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-11 m-auto ">
                            <h5 class="font-weight-bolder">Solicitante: <span class="font-weight-normal">{{$visto->nome}}</span></h5>
                            <h5 class="font-weight-bolder">Destino: <span class="font-weight-normal">{{$visto->destino}}</span></h5>
                            <h5 class="font-weight-bolder">Tipo: <span class="font-weight-normal text-capitalize">{{$visto->tipo}}</span></h5>
                        </div>
                        <div class="col-12 m-auto ">
                            <div class="m-auto">
                                <p class="text-center">Foi enviado para o seu email [{{$visto->email}}] o número do seu visto, que deverá usá-lo 
                                    para consultar o estado de sua solicitação.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="text-center mt-4 font-weight-bold">
                <a href="{{route('visas.create')}}">Voltar a solicitar</a>
            </div>
        </section>
            

        

@endsection