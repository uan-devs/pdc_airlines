@extends('portal.layout.template')
@section('title','Editar '.$doc->nome)

@section('content')



<section class="vistos w-100 container py-3 px-5 ">
            <div class="d-flex flex-column align-items-center mt-3 mb-5">
                <h3 class="font-weight-bolder">Alterar meu visto</h3>
                <hr class="bg-danger m-0 rounded" style="width: 10%;padding: 2px;">
            </div>
            <div class="w-75 m-auto">
                    @if(session('error'))
                        <div class="alert alert-danger " role="alert">
                            {{session('error')}}
                        </div>
                    @endif
                    @if(session('sucess'))
                        <div class="alert alert-success " role="alert">
                            {{session('sucess')}}
                        </div>
                    @endif
            </div>
            <div class="p-3 rounded-lg border w-75 m-auto">
                <h5 class=" mb-4 font-weight-normal">Editar <span class="font-weight-bold text-capitalize">{{$doc->nome}}</span></h5>
                <form action="{{route('documents.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="idDoc" value="{{$doc->id}}">
                    <div class="form-row">
                        <div class="form-group col-12 col-md-8">
                            <label for="code">Selecione um novo arquivo</label>
                            <input  type="file" required name="file" class="form-control " id="" placeholder="Arquivo">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12 ">
                            <button type="submit" class="w-25 btn btn-dark ">Guardar</button>
                            <a href="{{route('visas.edit',$doc->id_visto)}}" class="btn btn-danger">Voltar</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
            

        

@endsection
