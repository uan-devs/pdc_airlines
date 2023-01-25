@extends('portal.layout.template')
@section('title','PDC AIRLINES')
@section('content')

<div  class="vistos w-100  py-5 " style="background-color: #eee;">
    <div class="text-center">
        <h4>Selecionar voo de </h4>
        <div class="d-flex justify-content-center">
            <div class="mr-3 rounded-md w-50 border border-info p-1">
                <span class="text-info " style="font-weight: bold;">Luanda</span> --> <span class="mr-2 text-info" style="font-weight: bold;">Lisboa</span>
                | <span class="ml-2">{{session("search")['partida']}}</span> | <span class="ml-2">{{session("search")['tipo']}}</span>
                | <span class="ml-2">{{session('search')['qtd']}}</span> Passageiros

            </div>
            <div>
                <a href="#" class="btn btn-primary btn-sm ">Modificar pesquisa</a>
            </div>
        </div>
    </div>
    <div class="voos mt-5 w-100 container">
        @foreach($voos as $item)
        <div class="voo bg-white rounded-md p-3  mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <a id="aLogo" href="{{route('portal.home')}}" class="text-dark" style="font-size: 1.5rem;">
                    <i class="far fa-paper-plane"></i>
                    PDC
                    </a>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <div class="d-flex flex-column justify-content-center  mr-2 text-center">
                        <span class="" style="font-size: 1.5em;font-weight:bolder;"> {{date_format(new DateTime($item->hora),"H:i") }}</span>
                        <span>{{ $item->cidade_origem}}</span>
                    </div>
                    <div class="mr-2">
                        ---- <i class="fas fa-plane" style="font-size: 1.2em;"></i> ----
                    </div>
                    <div class="d-flex flex-column">
                        <span class="" style="font-size: 1.5em;font-weight:bolder;"> 
                            {{date_format(new DateTime($item->chegada),"H:i")  }}
                        </span>
                        <span>{{ $item->cidade_destino}}</span>
                    </div>
                </div>
                <div class="d-flex flex-column justify-content-center  mr-5 text-center">
                    <h5 style="font-weight:600">{{$item->duracao_estimada}} Horas</h5>
                    <span class="">Directo</span>
                </div>
                <div class="d-flex flex-column justify-content-start ">
                    <span class="text-center">Tarifas</span>
                    
                    <div class="d-flex ">
                    @foreach($item->classes as $classe)
                        <div data-toggle="collapse" href="#collapse{{$classe->id}}{{$item->id_voo}}" role="button" aria-expanded="false" aria-controls="collapseExample" class="portal-tarifa rounded-lg border border-info p-2 mr-3 text-center" style="width: 200px;">
                            <h4 style="text-transform:capitalize;">{{$classe->nome}}</h4>
                            <span style="font-weight: bolder;font-size:x-large;">2.044</span>
                        </div>
                        <!-- <div class="portal-tarifa rounded-lg border border-info p-2 text-center" style="width: 200px;">   
                            <h4>Executiva</h4>
                            <span style="font-weight: bolder;font-size:x-large;">3.500</span>
                        </div> -->
                    @endforeach
                    </div>
                    
                </div>
            </div>
            <!-- COLLAPSES DAS TARIFAS -->
        @foreach($item->classes as $classe)
        <div class="collapse mt-3" id="collapse{{$classe->id}}{{$classe->id_voo}}">
          <div class="card card-body ">

                <div class=" d-flex flex-column  align-items-end">
                    <div class="d-flex justify-content-end align-items-center">
                    @foreach($item->tarifas as $tarifa)
                        @if($tarifa->classe_id == $classe->id)
                        <div class=" border  shadow-sm ml-3" style="width:200px">
                            <div class=" text-center p-1" style="border-bottom:1px solid #ddd;text-transform:capitalize;">
                                <span style="font-weight: bold;font-size:1.3em">{{$tarifa->tarifa}}</span>
                            </div>
                            <div class="d-flex flex-column text-center p-1" >
                                <span style="font-size:1.5em">{{$tarifa->preco}} KZ</span>
                                <span class="text-primary">{{$tarifa->lugares}} lugares restantes</span>
                            </div>
                            <div class=" text-center py-2" style="border-top:1px solid #ddd;">
                                <a href="{{route('portal.compra')}}?id_voo={{$item->id_voo}}&id_tarifa={{$tarifa->id_voo_tarifa}}&passageiros={{session('search')['qtd']}}&tipo={{session('search')['tipo']}}" 
                                class="btn btn-sm btn-danger">SELECIONAR</a>

                            </div>
                        </div>
                        @endif
                    @endforeach
                    </div>
                </div>
                
            
          </div>
        </div>
        @endforeach
        <!-- FIM DOS COLLAPSES DAS TARIFAS -->
        </div>
        
        @endforeach
        
       


    </div>
</div>


@endsection