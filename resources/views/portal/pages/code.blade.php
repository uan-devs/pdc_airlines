@extends('portal.layout.template')
@section('title','Consultar Vistos ')

@section('content')



<section class="vistos w-100 container py-3 px-5 ">
            <div class="d-flex flex-column align-items-center mt-5 mb-3">
                <h3 class="font-weight-bolder">Alterar meu visto</h3>
                <hr class="bg-danger m-0 rounded" style="width: 10%;padding: 2px;">
                <p class="mt-2">Para poder alterar os dados da sua solicitação de visto, deve fornecer o seu código secreto</p>
            </div>
            <div class="w-50 m-auto">
                    @if(session('error'))
                        <div class="alert alert-danger " role="alert">
                            {{session('error')}}
                        </div>
                    @endif
            </div>
            <div class="p-3 rounded-lg border w-50 m-auto">
                <h5 class="text-center mb-4 font-weight-bold" >Solicitante: <span class="font-weight-normal">{{$visto->nome}}</span></h5>
                <form action="{{route('visas.secret.code')}}" method="post">
                    @csrf
                    <input type="hidden" name="idVisto" value="{{$visto->id}}">
                    <div class="form-row">
                        <div class="form-group col-12 col-md-10">
                            <label for="code">Digite o código secreto</label>
                            <input  type="text" required name="code" class="form-control " id="" placeholder="Codigo Secreto">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12 ">
                            <button type="submit" class="w-50 btn btn-dark ">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
            

        

@endsection
