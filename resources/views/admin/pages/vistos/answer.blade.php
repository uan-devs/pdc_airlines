@extends('admin.layout.template')
@section('title','Visa - Vistos')


@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h3 class="font-weight-bold">Responder solicitacão de visto</h3>
        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            <div class="row font-weight-bold">
                <div class="col-4">
                    <h6 class="font-weight-bold">Requerente: <span class="text-primary">{{$visto->nome}}</span></h6>
                </div>
                <div class="col-4">
                    <h6 class="font-weight-bolder">Tipo de Visto: <span class="text-primary text-capitalize">{{$visto->tipo}}</span></h6>
                </div>
                <div class="col-4">
                    <h6 class="font-weight-bolder">Destino: <span class="text-primary">{{$visto->destino}}</span></h6>
                </div>
            </div>
            <div class="row font-weight-bold">
                <div class="col-4 mt-2">
                    @if($visto->estado=='pendente')
                    <h6 class="font-weight-bold">Estado: <span class="text-capitalize text-white bg-primary py-1 px-2 rounded-lg">{{$visto->estado}}</span></h6>
                    @elseif($visto->estado == 'aprovado')
                    <h6 class="font-weight-bold">Estado: <span class="text-capitalize text-white bg-success py-1 px-2 rounded-lg">{{$visto->estado}}</span></h6>
                    @else()
                    <h6 class="font-weight-bold">Estado: <span class="text-capitalize text-white bg-danger py-1 px-2 rounded-lg">{{$visto->estado}}</span></h6>
                    @endif
                    
                </div>
            </div>
        </div>

        <!-- TABELA  -->
        <div class="w-full p-4 overflow-hidden bg-white rounded-lg shadow-xs">
            <h5 class="mb-3">Responder</h5>
            @if(session('error'))
                <div class="alert alert-danger " role="alert">
                    {{session('error')}}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success " role="alert">
                    {{session('success')}}
                </div>
            @endif
            <div class="p-3 border rounded">
                <form action="{{route('vistos.answer.store')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$visto->id}}">
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="status">Estado do Visto</label>
                            <select name="status" id="status" class="form-control form-control">
                                <option value="pendente">Deixar Pendente</option>
                                <option value="aprovado">Aprovar</option>
                                <option value="reprovado">Reprovar</option>
                                <option value="entrevista">Passar para entrevista</option>
                            </select>
                        </div>
                        <div class="form-group col-3 d-flex align-items-end">
                            <button class="btn btn-primary ">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>


    </div>
</main>

@endsection