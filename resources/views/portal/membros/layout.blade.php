<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title")</title>
    <base href="/public">
    <link rel="stylesheet" href="{{ asset('/css/responsivo.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/custom_portal.css') }}">
    <script src="https://kit.fontawesome.com/6b4ddefc79.js" crossorigin="anonymous"></script>
</head>
<body>
                                            
    <header style="height: 5rem;color:#ffffff !important;" 
        class="fixed-top px-5 bg-dark w-100 text-white d-flex justify-content-start align-items-center ">
        <div class="logo w-25">
            <a id=""  class="d-flex align-items-center text-white" style="font-size: 1.7rem;">
                <i class="fa fa-paper-plane mr-3" ></i>
                <!-- <img src="{{asset('img/logo.png')}}" width="10px" height="40px" alt=""> -->
                <span>PDC Airlines</span>
            </a>
        </div>
        
        <!-- <nav class=" menu d-flex justify-content-end  "> -->
            <ul class=" w-75 d-flex justify-content-start align-items-end text-white">
                <li class="mr-4" >
                
                    <a href="{{route('membro.perfil',session('membro')->id)}}" class="link text-white">
                        <i class="fas fa-home"></i> 
                        Meus Dados
                    </a>
                </li>
                <li class="mr-4" >
                
                    <a href="{{route('membro.compras',session('membro')->id)}}" class="link text-white">
                        <i class="fas fa-home"></i> 
                        Minhas Compras
                    </a>
                </li>
                
                <li class="mr-4" >
                    <a href="{{route('portal.home')}}" class="link text-white">
                        <i class="fas fa-user"></i> 
                        Voos
                    </a>
                </li>
                <li class="mr-4" >
                
                    <a  class="link text-white">
                        <i class="fas fa-user"></i> 
                        {{session('membro')->nome}} {{session('membro')->sobrenome}}
                    </a>
                </li>
                <li class="mr-4" >
                <a  class="link text-white" href="{{route('membro.logout')}}">
                        <i class="fas fa-user"></i> 
                        Terminar Sessão
                    </a>
                </li>

                
            </ul>
        </nav>

        <button class="btn-show navbar-toggler" id="btn-show" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon text-white ">
                <i class="fas fa-bars">
                 <img src="img/icons/menu.png" alt=""> 
                </i>
            </span>
        </button>
        

    </header>
    <!-- mobile nav -->

    <nav id="navbarNavDropdown" class="collapse  navbar-collapse mobile-nav position-fixed w-75 h-100" style=" background-color: rgba(0,0,0,0.9);">
    <div class="d-flex justify-content-end p-3">
        <span id="btn-close" class="text-white" style="font-size: large;font-weight:bolder;border:1px solid white;padding:1px 8px">X</span>
    </div>
    <ul class="  d-flex flex-column  p-0">
                <li class="d-block">
                    <a href="" class="d-block b p-3 text-white">Página Inicial</a>
                </li>
                <li class=" nav-item dropdown">
                    <a href="#" class="nav-link  p-3  text-white dropdown-toggle" role="button" 
                        data-toggle="dropdown" aria-expanded="false">Voos</a>
                    
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="">Meus Dados</a>
                      <a class="dropdown-item" href="">Minhas compras</a>
                      <a class="dropdown-item" href="">Minhas Milhas</a>
                    </div>

                </li>
                <li class=""><a href="{{route('login')}}" class="d-block  p-3 text-white">Acesso</a></li>
            </ul>
    </nav>
    
    <main class="" style="padding-top: 5rem;width: 100vw;">



        @yield("content")
    


    </main>

<footer class=" rodape" style="background-color: #000000; opacity:0.93" >
    <div class="container py-5 ">
        <div class="row">
        <div class="col-sm-12 col-md-3 logo mb-5">
            <a href="" class="text-white" style="font-size: 1.7rem;">
                <i class="far fa-paper-plane"></i>
                PDC Airlines
            </a>
        </div>
        <div class="col-sm-12 col-md-3 text-white mb-5">
            <h5 class="border-bottom pb-2 font-weight-bold" 
                style="border-bottom-style: dotted !important; ">
                Links Rápidos
            </h5>
            <div class="d-flex flex-column ">
                <a href="#" class="text-white hover-sublinhado" >Governo de Angola</a>
                <a href="#" class="text-white hover-sublinhado">Serviço de Migração e Estrangeiro</a>
                <a href="#" class="text-white hover-sublinhado">Ministério do Comércio</a>
            </div>
        </div>

        <div class="col-1"></div>
        <div class="col-sm-12 col-md-4 text-white ">
            <h5 class="font-weight-bold">Fale Connosco</h5>
            <div class="">
                <form action="" method="post">
                    @csrf
                        <div class="form-group ">
                            <label for="">Seu Email</label>
                            <input type="text" name="email" class="form-control text-dark focus-danger" id="" placeholder="digite seu Email..."
                            style="background-color: #ffffff";>
                        </div>
                        <div class="form-group ">
                            <label for="">Sua Mensagem</label>
                            <textarea name="mensagem" 
                            class="form-control text-dark focus-danger " id="" cols="30" rows="5" placeholder="digite a sua mensagem..."
                            style="background-color: #ffffff ;"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-large btn-danger w-100">Enviar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
</footer>

          <!--  MODAL PARA CONSULTAR VISTO -->
              <div class="modal fade" id="modalConsultar" tabindex="-1" aria-labelledby="exampleModalLabel" 
                        aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" 
                                style="color: black;" >Consultar Visto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="">
                            @csrf
                            <input type="hidden" name="id_voo" value="">
                          <div class="modal-body" style="color: black;">
                                <div class="form-group ">
                                    <label for="number">Digite o numero do Visto</label>
                                    <input  type="text" required name="number" class="form-control " id="" placeholder="Numero do visto">
                                </div>
                                <div class="form-group  ">
                                    <label for="data">Data de Nascimento</label>
                                    <input type="date" required class="form-control " name="data" id="">
                                </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Consultar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            
                          </div>
                          </form>
                          
                        </div>
                      </div>
                    </div>
                    <!-- FIM DO MODAL PARA CONSULTAR VISTO-->

   <!-- MODAL PARA STATUS DE OPERALÇÃO -->
   @if(session('error'))
<!-- Modal -->
<div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger font-weight-bolder " id="exampleModalLabel"style="font-size: 1.5em;" >Atenção</h5>
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
        <h5 class="modal-title text-success font-weight-bolder " id="exampleModalLabel"style="font-size: 1.5em;" >Concluído</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark text-center" style="font-size: 1.2em;">
            {{session('success')}}
      </div>
    </div>
  </div>
</div>
                       
@endif


    <script src="{{ asset('/js/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="{{ asset('/js/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/jquery/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('/js/custom_portal.js') }}"></script>
    <!-- <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script> -->

<script>
     $('#modalError').modal('show');
     $('#modalSuccess').modal('show');
    $('.carousel').carousel({
        interval: 10000,
        ride:'carousel'
    })

    $('#selectVisto').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = optionSelected.attr('data-target');
            $('.collapse').collapse('hide');
            $(valueSelected).collapse("show")
            // alert(valueSelected)
        });

    $('#btn-show').click(function(e){
        $("#navbarNavDropdown").slideToggle(1000);
        // console.log("HEY")
    });
    $('#btn-close').click(function(e){
        $("#navbarNavDropdown").hide();
        // console.log("HEY")
    })
</script>
</body>
</html>