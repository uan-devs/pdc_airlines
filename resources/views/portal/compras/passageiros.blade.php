@extends('portal.layout.template')
@section('title','PDC AIRLINES - Efctuar compra')
@section('content')

<div  class="vistos w-100  py-2 " style="background-color: #eee;">
    <div class="container mt-3">
        <div >
            <h4>Dados dos passageiros</h4>
            <p>Por favor, preencha os seus dados correctamente</p>
        </div>

        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div style="width: 65%;">
                <form action="{{route('portal.efectuar')}}" method="post">
                    @csrf
                    <input type="hidden" name="id_voo" value="{{$detalhes['id_voo']}}">
                    <input type="hidden" name="id_voo_tarifa" value="{{$detalhes['id_tarifa']}}">
                    <input type="hidden" name="tipo" value="{{$detalhes['tipo']}}">
                    <input type="hidden" name="qtd" value="{{$detalhes['passageiros']}}">
                    <div class="d-flex flex-column justify-content-start">
                    
                        @for($i = 1; $i <= $detalhes['passageiros'];$i++)
                            <div class="w-100 bg-white rounded-lg shadow-lg p-3 mb-2">
                                <div>
                                    <h4>Passageiro {{$i}}</h4>
                                </div>
                                <label for="" class="mt-3">Titulo</label>
                                <div class="form-row px-4">
                                    <div class="form-group form-check col-12 col-md-1">
                                        <label for="example{{$i}}">
                                        <input  class="form-check-input" type="radio" 
                                                name="titulo{{$i}}" id="example{{$i}}" 
                                                value="sr" checked class="form-control">
                                          Sr
                                        </label>
                                    </div>
                                    <div class="form-group form-check col-12 col-md-1">
                                        <label for="example">
                                        <input  class="form-check-input" type="radio" 
                                                name="titulo{{$i}}" id="example" 
                                                value="Sra" class="form-control"
                                             >
                                          Srª
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-12 col-md-5">
                                        <label for="nome{{$i}}">Nome</label>
                                        <input class="form-control" type="text" name="nome{{$i}}" id="" placeholder="Nome do Passageiro">
                                    </div>
                                    <div class="form-group col-12 col-md-5">
                                        <label for="sobrenome">Sobrenome</label>
                                        <input class="form-control" type="text" name="sobrenome{{$i}}" id="" placeholder="Sobrenome do Passageiro">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-12 col-md-5">
                                        <label for="email{{$i}}">Email</label>
                                        <input class="form-control" type="email" name="email{{$i}}" id="" placeholder="Email do Passageiro">
                                    </div>
                                    <div class="form-group col-12 col-md-5">
                                        <label for="telefone">Telefone</label>
                                        <input class="form-control" type="text" name="telefone{{$i}}" id="" placeholder="Telefone do Passageiro">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-12 col-md-5">
                                        <label for="data">Data de Nascimento</label>
                                        <input class="form-control" type="date" name="data{{$i}}" id="" placeholder="Data de nascimento do Passageiro">
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="w-100 bg-white rounded-lg shadow-lg p-3 mt-2 mb-2">
                        <h4>Selecione o metodo de pagamento</h4>                    
                        <div class="">
                            <div class="form-group form-check col-12 col-md-4">
                                <label for="ref">
                                <input  class="form-check-input" type="radio" 
                                        name="pagamento" id="ref" 
                                        value="referencia" class="form-control" checked
                                     >
                                  Pagamento por Multicaixa
                                </label>
                            </div>

                        <input type="submit" value="Concluir Compra" class="btn btn-primary btn-lg mt-2">
                        </div>
                    </div>

                </form>
            </div>
            <div style="width: 30%;">
                <div class="w-100 bg-white rounded-lg shadow-lg">
                    <div class="top p-3" style="border-bottom: 1px solid #bbb;">
                        <h4 class="text-danger text-center bold">Resumo da sua compra</h4>
                    </div>
                    <div class="px-2 py-2 mt-2">
                        <h5 class="bold text-center mb-3">Detalhes do Voo</h5>
                        <div class="text-center">
                            <h6 class="text-center bold">Data: {{$voo->data_partida}}</h6>
                            <h6 >{{$voo->cidade_origem}} [ <span class="bold">{{date_format(new DateTime($voo->hora),"H:i")  }}</span> ]</h6>
                            <h6 >{{$voo->cidade_destino}} [ <span class="bold">{{date_format(new DateTime($voo->chegada),"H:i")  }}</span> ]</h6>
                            <h6>Duração: <span class="bold">{{$voo->duracao_estimada}} Horas</span></h6>
                        </div>
                        <div class="text-center">
                            <h6 class="text-center bold">Tarifa: <span class="text-primary">BASIC</span></h6>
                            <h6 class="text-center bold">Preço da Tarifa: <span class="text-success">4892 KZ</span></h6>
                            <h6 class="bold">Passageiros: {{$detalhes['passageiros']}}</h6>
                        </div>
                        <h5 class="bold text-center mb-3 mt-3">Preço Final</h5>
                        <div class="text-center">
                            <h6 class="text-center bold text-success">4892 KZ</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>


@endsection