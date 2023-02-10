@extends('portal.layout.template')
@section('title','Consultar Vistos ')


@section('content')



<section class="vistos w-100 container py-3 px-5 ">
            <div class="d-flex flex-column align-items-center mt-5 mb-3">
                <h3 class="font-weight-bolder">Consultar estado do Visto</h3>
                <hr class="bg-danger m-0 rounded" style="width: 10%;padding: 2px;">
                <p class="mt-2">A partir da plataforma poderá consultar o estado em que está o seu visto</p>
            </div>
            <div class="w-75 m-auto">
                    @if(session('error'))
                        <div class="alert alert-danger " role="alert">
                            {{session('error')}}
                        </div>
                    @endif
            </div>
            <div class="p-3 rounded-lg border w-75 m-auto">
                <form action="{{route('visas.status')}}" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-12 col-md-4">
                            <label for="number">Digite o numero do Visto</label>
                            <input  type="text" required name="number" class="form-control " id="" placeholder="Numero do visto">
                        </div>
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="data">Data de Nascimento</label>
                            <input type="date" required class="form-control " name="data" id="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-2">
                            <button type="submit" class="btn btn-dark ">Consultar</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
            

        

@endsection