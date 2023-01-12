@extends('admin.layout.template')
@section('title','PDC Airlines - Lugares')

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
                Lugares do Voo
            </h2>
        </div>

        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs">
          <div class="w-100 border " 
                style="border-width: 5px !important; min-height:55vh;background-image:url('img/plane2.jpg');background-position: center;background-size: 250%;background-repeat: no-repeat;"
            >
                <div class="p-3 places w-100 bg-white border" style="height: 35vh; margin-top:6%; overflow:scroll" >
                

                @for($i = 1,$next = 0; $i<=4; $i++,$next+=15)
                <div class="d-flex justify-content-start align-items-center no-wrap mb-3">
                    <h4 class="mr-3 bolder text-dark border-right border-dark px-2" 
                            style="border-width: 4px!important;">
                            {{$i}}
                        </h4>
                    @for ($j = $next; $j < ($lugaresPorFila + $next); $j++)
                            <span class="px-3 py-2 rounded-lg bg-primary text-white mx-1">{{($lugares[$j])->numero}}</span>
                    @endfor
                </div>
                @endfor
                
                    
                </div>
          </div>
        </div>
        <div class="w-full mb-3 p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
        </div>



    </div>
</main>


<!-- MODAL PARA STATUS DE OPERALÇÃO -->
@if(session('error'))
<!-- Modal -->
<div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger font-weight-bolder " id="exampleModalLabel"style="font-size: 1.5em;" >Erro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark text-center" style="font-size: 1.2em;">
            {{session('error')}}
      </div>
    </div>
  </div>
</div>
                       
@endif

@if(session('success'))
<!-- Modal -->
<div class="modal fade" id="modalSuccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success font-weight-bolder " style="font-size: 1.5em;"id="exampleModalLabel" >Sucesso!!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark text-canter" style="font-size: 1.2em;">
            {{session('success')}}
      </div>
    </div>
  </div>
</div>
                       
@endif


@endsection