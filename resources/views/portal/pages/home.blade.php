@extends('portal.membros.layout')
@section('title','PDC AIRLINES')
@section('content')
 <!-- Banner with slideshow -->
 <section class="w-100 bg-danger" style="min-height: 80vh;">
            <div id="carouselExampleControls" class="carousel slide" style="height: 90vh;" >
                <div class="carousel-inner " >
                  <div class="carousel-item active">

                    <div class="w-100 "  
                    style="height: 90vh;
                    background-image: url('img/model-777.jpeg');
                    background-position: center;background-size: cover;">
                        <div style="background-color: rgba(0,0,0,0.5);" 
                            class="w-100 h-100 d-flex flex-column justify-content-center align-items-center ">
                                <div id="textoPrincipal" class="text-white  w-50  d-flex flex-column justify-content-start align-items-start">
                                    <span class="border-left border-danger pl-2 mb-2 font-weight-bold"
                                            style="border-width: 4px !important;">
                                        Bem vindo</span>
                                    <h1 id="meuTexto" style="font-size: 2.5rem;color:white" 
                                    class="mb-4 font-weight-bolder">Viaje com qualidade</h1>
                                </div>
                                <div class="w-75 px-3">
                                    <div class="search rounded-lg bg-white w-100 p-3">
                                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                          <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Reservar um voo</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                          <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                          <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                                        </li>
                                      </ul>
                                      <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <div class=" px-3 mt-3">
                                                <form action="{{route('portal.voos')}}" class="px-3" method="post">
                                                  @csrf
                                                    <div class="form-row  ml-3">
                                                        <div class="form-group form-check col-12 col-md-2">
                                                            <label for="exampleRadios1">
                                                            <input  class="form-check-input" type="radio" 
                                                                    name="tipo" id="exampleRadios1" 
                                                                    value="ida" checked class="form-control"
                                                                    onclick="$('#select_regresso').fadeOut();">
                                                              Só ida
                                                            </label>
                                                            
                                                        </div>
                                                        <div class="form-group form-check col-12 col-md-2">
                                                            <label for="exampleRadios2">
                                                            <input  class="form-check-input" type="radio" 
                                                                    name="tipo" id="exampleRadios2" 
                                                                    value="ida-volta" class="form-control"
                                                                    onclick="$('#select_regresso').fadeIn();">
                                                              Ida e Volta
                                                            </label>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-12 col-md-3">
                                                            <label for="origem">Origem</label>
                                                            <select name="origem" id="origem" class="form-control">
                                                              
                                                              @foreach($aeroportos as $item)
                                                                  <option value="{{$item->id}}">{{$item->pais}}, {{$item->cidade}}, {{$item->aeroporto}}</option>
                                                              @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-12 col-md-3">
                                                            <label for="destino">Destino</label>
                                                            <select name="destino" id="destino" class="form-control">
                                                                @foreach($aeroportos as $item)
                                                                  <option value="{{$item->id}}">{{$item->pais}}, {{$item->cidade}}, {{$item->aeroporto}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-12 col-md-3">
                                                            <label for="partida">Data de Partida</label>
                                                            <input class="form-control" type="date" name="data_partida" id="partida">
                                                        </div>
                                                        <div class="form-group col-12 col-md-3 " style="display: none;"  id="select_regresso">
                                                            <label for="regresso">Data de Regresso</label>
                                                            <input class="form-control" type="date" name="data_regresso" id="regresso">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-12 col-md-2">
                                                            <label for="quantidade">Nº de Passageiros</label>
                                                            <input type="number" name="qtd" min="1" max="3" value="1" class="form-control"  id="quantidade">
                                                        </div>
                                                        <div class="form-group col-12 col-md-10">
                                                            <div class="w-100 d-flex flex-column justify-content-center align-items-end">
                                                            <button class="btn btn-danger mt-3" type="submit">Pesquisar voo</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                                      </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                  </div>
                  
                </div>

               
            </div>
        </section>

        <section class="vistos w-100 container py-5">
            <div class="d-flex flex-column align-items-center mb-5">
                <h1 class="font-weight-bolder">Cidades Mais visitadas</h1>
                <hr class="bg-danger m-0 rounded" style="width: 5%;padding: 2px;">
            </div>

            <div id="pai" class="w-100 ">
                <div class="card-deck">
                    <div class="card">
                      <img src="img/visto01.jpeg" class="card-img-top" alt="...">
                      <div class="card-body">
                        <h5 class="card-title font-weight-bold">Visto de Estudo</h5>
                        <p class="card-text">O visto de estudo é concedido ao cidadão, 
                            pelas Missões diplomáticas e consulares angolanas a fim de frequentar um programa de estudos em 
                            escolas públicas ou privadas, assim como em centros de formação profissional 
                            para obtenção de um grau académico ou profissional ou para realização de estágios
                             em empresas e serviços públicos ou privados.</p>
                      </div>
                      <div class="card-footer d-flex justify-content-center">
                        <!-- <small class="text-muted">Last updated 3 mins ago</small> -->
                        <a href="#" class="btn btn-danger btn-large">Saiba Mais</a>
                      </div>
                    </div>
                    <div class="card">
                      <img src="img/visto02.webp" class="card-img-top" alt="...">
                      <div class="card-body">
                        <h5 class="card-title font-weight-bold">Visto de Saúde</h5>
                        <p class="card-text">O visto de tratamento médico é concedido pelas Missões diplomáticas e consulares angolanas ao cidadão 
                            e destina-se permite a entrada do seu titular em Angola, 
                            a fim de efectuar tratamento em unidade hospitalar público ou privada.</p>
                      </div>
                      <div class="card-footer d-flex justify-content-center">
                        <!-- <small class="text-muted">Last updated 3 mins ago</small> -->
                        <a href="#" class="btn btn-danger btn-large">Saiba Mais</a>
                      </div>
                    </div>
                    <div class="card">
                      <img src="img/visto03.webp" class="card-img-top" alt="...">
                      <div class="card-body">
                        <h5 class="card-title font-weight-bold">Visto de Trabalho</h5>
                        <p class="card-text">O visto de trabalho é concedido pelas Missões diplomáticas e consulares angolanas 
                            a fim de exercer temporariamente uma actividade profissional 
                            remunerada no interesse do Estado ou por conta de outrem.</p>
                      </div>
                      <div class="card-footer d-flex justify-content-center">
                        <!-- <small class="text-muted">Last updated 3 mins ago</small> -->
                        <a href="#" class="btn btn-danger btn-large">Saiba Mais</a>
                      </div>
                    </div>
                  </div>
            </div>
            <div class="d-flex justify-content-center mt-5">
                <a href="#" class="btn btn-large text-white bg-dark w-25">Ver mais vistos</a>
            </div>
        </section>

        <section class="vistos w-100 container py-5">
            <div class="d-flex flex-column align-items-center mb-5">
                <h1 class="font-weight-bolder">Países</h1>
                <hr class="bg-danger m-0 rounded" style="width: 5%;padding: 2px;">
            </div>
            <div>
                <p class="text-center">
                    Solicite vistos para os mais variados destinos disponíveis na nossa plataforma
                </p>
            </div>
            <div id="fle" class="d-flex justify-content-center align-content-center flex-wrap">
                <marquee id="marque" behavior="" direction="">

                </marquee>
            </div>
        </section>
        <script src="{{ asset('/js/responsivo.js') }}"></script>
        <script src="{{ asset('/js/slides.js') }}"></script>
        <script src="{{ asset('/js/jquery/jquery.min.js') }}"></script>
        <script>
          responsivo()
          show()
          slide()
        </script>
@endsection



