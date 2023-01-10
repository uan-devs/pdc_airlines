@extends('admin.layout.template')
@section('title','Visa - Minha Conta')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <h1 class="mb-3">Minha Conta</h1>
    <div class="container grid px-0 mx-auto ">

       <!-- FORMULARIO  -->
        <div class="mb-4 p-3 bg-white rounded">
            <form action="{{route('conta.update')}}" method="post">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-5"> 
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" value="{{Auth::user()->name}}" required  class="form-control">
                    </div>
                    <div class="form-group col-md-5"> 
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{Auth::user()->email}}" required  class="form-control">
                    </div>
                </div>
                <div class=" mb-2">
                    @if($errors->any())
                      @foreach($errors->all() as $error)
                        <p class="text-danger ">{{$error}}</p>
                      @endforeach
                    @endif
                  </div>
                  <div class="center mb-2">
                      @if(session('sucess'))
                        <p class="text-success ">{!!session('sucess')!!}</h5> 
                      @endif
                  </div>
                  <div class="center mb-2">
                      @if(session('error'))
                        <p class="text-danger">{!!session('error')!!}</h5> 
                      @endif
                  </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Actualizar dados">
                </div>
            </form>
        </div>



        <div class="mt-2 p-3 bg-white rounded">
            <h3>Alterar Senha</h3>

            <form action="{{route('conta.new-password')}}" method="post">
                @csrf 
                <div class="form-row">
                    <div class="form-group col-md-4"> 
                        <label for="senha">Nova Senha</label>
                        <input type="password" name="new" id="senha" class="form-control ">
                    </div>
                </div>
                <div class="center mb-2">
                    @if($errors->any())
                      @foreach($errors->all() as $error)
                        <p class="text-danger">{{$error}}</p>
                      @endforeach
                    @endif
                  </div>
                  <div class="center mb-2">
                      @if(session('password_reseted'))
                        <p class="text-success">{!!session('password_reseted')!!}</h5> 
                      @endif
                  </div>
                  <div class="center mb-2">
                      @if(session('wrong_password'))
                        <p class="text-danger">{!!session('wrong_password')!!}</h5> 
                      @endif
                  </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                        <input type="submit" class="btn btn-primary" value="Guardar">
                  </div>
                </div>
            </form>
        </div>
    </div>
</main>

@endsection