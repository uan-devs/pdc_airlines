@extends('admin.layout.template')
@section('title','Visa - Utilizadores')


@section('content')


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-0 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 ">
            Adicionar Utilizador
        </h2>

       <!-- FORMULARIO  -->
        <div class="w-100 p-3 overflow-hidden bg-white rounded-lg shadow-xs">
            
            <div class="w-full overflow-x-auto ">
            
            <div>
            <form action="{{route('users-store')}}" method="post" >
                @csrf  
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="nome">Nome</label>
                      <input type="text" name="nome" placeholder="Ex: Joao Manuel" value="{{old('nome')}}" class="form-control" id="nome" >

                    </div>
                    <div class="form-group col-md-4">
                      <label for="exampleInputPassword1">Email</label>
                      <input type="email" name="email" placeholder="Ex: joao@gmail.com" value="{{old('email')}}" required class="form-control" id="exampleInputEmail1" >
                    </div>
                  </div>

                  <div class="center mb-2">
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
                        <p class="text-red-500 text-center">{!!session('error')!!}</h5> 
                      @endif
                  </div>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>

            </div>
        </div>


    </div>
</main>

@endsection