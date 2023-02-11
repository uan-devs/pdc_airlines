@extends('portal.membros.layout')
@section('title','PDC Airlines')


@section('content')

    <section class="w-100 bg-white p-5">
        <div>
        <h2 class="text-center">Seja Bem vindo(a) <span style="font-weight:bold">{{session('membro')->nome}} {{session('membro')->sobrenome}}</span></h2> 
        <h4 class="text-center">Você tem <span class="text-info" style="font-weight: bold;">{{session('membro')->milhas}}</span> milhas</h4>
    
        </div>

        <div class="mt-5">
            <h3 class="text-center">Oque pode fazer com suas milhas?</h3>

        </div>

        <div class="mt-4">
            <div class="d-flex justify-content-center">
                <div class="border w-25 mr-4">
                    <div class="mb-5">
                        <figure>
                            <img src="{{asset('img/first-class-2.jpeg')}}" alt="" height="200px">
                        </figure>
                    </div>
                    <div class="p-2 text-center">
                        <h4>Usufruir de regalias</h4>
                    </div>
                </div>
                <div class="border w-25 mr-4">
                    <div class="mb-5">
                        <figure>
                            <img src="{{asset('img/model-777.jpeg')}}" alt="" height="200px">
                        </figure>
                    </div>
                    <div class="p-2 text-center">
                        <h4>Receba promoções</h4>
                    </div>
                </div>
                <div class="border w-25 mr-4">
                    <div class="mb-5">
                        <figure>
                            <img src="{{asset('img/model-777-seats.webp')}}" alt="" height="200px">
                        </figure>
                    </div>
                    <div class="p-2 text-center">
                        <h4>Benefícios Exclusivos</h4>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection