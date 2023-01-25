@extends('portal.layout.template')
@section('title','Solicitar Visto ')
@section('content')
@if(!session('success'))

<script src="{{ asset('/js/validar.js') }}"></script>   
<script>
     validar();
</script>  
<section class="container mt-5">
            <div class="d-flex flex-column align-items-center mb-3 mt-2">
                <h3 class="font-weight-bolder">Solicitar Visto</h3>
                <hr class="bg-danger m-0 rounded" style="width: 5%;padding: 2px;">
                <p class="mt-3 ">Preencha o formulário abaixo para solicitar o teu visto</p>
            </div>

            <div class="p-3 rounded-lg border ">
                <div>
                    @if(session('error'))

                        <div class="alert alert-danger " role="alert">
                            {{session('error')}}
                        </div>
                    @endif
                </div>
                <div>
                    @if(session('sucess'))
                        <div class="alert alert-success " role="alert">
                            {{session('sucess')}}
                        </div>
                    @endif
                </div>
                <div>
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach($errors->all() as $error)
                                <p class="text-danger font-weight-bolder">{{$error}}</p>
                            @endforeach
                        </div>
                        @endif
                   
                </div>
                <form class="form" action="{{route('visas.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h6 class="mb-3 font-weight-bold">Dados do Visto</h6>
                    <div class="form-row">
                        
                        <div class="form-group col-12 col-md-4 mr-5">
                            <label for="">Tipo de Visto</label>
                            <select name="tipo" id="selectVisto" class="form-control form-control-lg">
                                <option value="estudo" data-toggle="collapse" data-target="#collapseEstudo" >Visto de Estudo</option>
                                <option value="saúde" data-toggle="collapse" data-target="#collapseSaude" >Visto de Saúde</option>
                                <option value="trabalho"data-toggle="collapse" data-target="#collapseTrabalho" >Visto de Trabalho</option>
                                
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="">País de Destino</label>
                            <select name="destino" id="" class="form-control form-control-lg">
                                @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <h6 class="font-weight-bold mb-3 mt-5">Dados Pessoais</h6>
                    <div class="form-row mt-0">
                        <div class="form-group col-12 col-md-4 mr-5">
                            <label for="">Nº de Bilhete</label>
                            <input type="text" id="bilhetes" onkeyup="validarBi()" name="bilhete" 
                            required class="form-control-lg form-control" id="" placeholder="Ex:006461129LA046"
                            <label id="vBi"></label>
                        </div>
                        <div class="form-group col-12 col-md-4 mr-5">
                            <label for="">Nº do Passaporte</label>
                            <input type="text" onkeyup="validarPassaPorte()"  name="passaporte" 
                            placeholder="Ex:o040la03"
                            required class="form-control-lg form-control" id="pass">
                            <label id="vPass"></label>
                        </div>
                        
                    </div>

                    <div class="form-row mt-4">
                        <div class="form-group col-12 col-md-4 mr-5">
                            <label id="labell" for="">Nome Completo</label>
                            <input type="text" name="nome" onkeyup="validarNome()" 
                            placeholder="Seu nome completo"
                            required class="form-control-lg form-control" id="name">
                            <label id="vNome"></label>
                        </div>
                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Data de Nascimento</label>
                            <input type="date" id="datas" required class="form-control form-control-lg" name="data_nascimento" id="">
                            <label id="vData"></label>
                        </div>

                        <div class="form-group col-12 col-md-3 mr-5">
                            <label for="">Gênero</label>
                            <select name="genero" id="" class="form-control form-control-lg">
                                <option value="m">Masculino</option>
                                <option value="f">Femenino</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-row mt-0">
                        <div class="form-group col-12 col-md-4 mr-5">
                            <label for="">Endereço</label>
                            <input type="text" name="endereco" onkeyup="validarEnde()" 
                            placeholder="Ex:Casa nº6, rua da vaidade"
                            required class="form-control-lg form-control" id="ende">
                            <label id="vEnde"></label>
                        </div>

                        <div class="form-group col-12 col-md-3">
                            <label for="">Estado Civil</label>
                            <select name="estado_civil" id="" class="form-control form-control-lg">
                                <option value="solteiro">Solteiro</option>
                                <option value="casado">Casado</option>
                                <option value="viúvo">Viúvo</option>
                                <option value="divorciado">Divorciado</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-0">
                        <div class="form-group col-12 col-md-4 mr-5">
                            <label for="">Email (opcional)</label>
                            <input type="email" name="email" 
                            placeholder="Ex: seuemail@gmail.com"
                            onkeyup="IsEmails()"  class="form-control form-control-lg" id="emails">
                            <label id="vEmail"></label>
                        </div>
                        <div class="form-group col-12 col-md-3 ">
                            <label for="">Telefone</label>
                            <input type="number" name="telefone" onkeyup="validarTel()" 
                            placeholder="Ex:(+244) 943 593 984"
                            class="form-control-lg form-control" id="tel">
                            <label id="vTel"></label>
                        </div>
                        
                    </div>

                    <h6 class="font-weight-bold mb-3 mt-5">Carregar Documentos</h6>
                    <div class="form-row mt-0">
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Bilhete</label>
                            <input class="files" type="file" name="doc_bilhete" required class="form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-2 mr-2">
                            <label for="">Passaporte</label>
                            <input class="files" type="file" name="doc_passaporte" required class="form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Fotografia</label>
                            <input class="files" type="file" name="doc_foto" required class="form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Declaração de Serviço</label>
                            <input class="files" type="file" name="doc_declaracao_de_servico" required class="form-control" id="">
                        </div>
                        
                    </div>
                    <div class="form-row mt-5">
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Recibo de Salario</label>
                            <input class="files" type="file" name="doc_recibo_de_salario" required class="form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Contrato de arrendamento</label>
                            <input class="files" type="file" name="doc_contrato_de_arrendamento" required class="form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Extracto Bancário</label>
                            <input class="files" type="file" name="doc_extracto_bancario" required class="form-control" id="">
                        </div>
                        
                    </div>

                    <div class="form-row mt-5 especific-estudo collapse show"  id="collapseEstudo">
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Certificado Academico</label>
                            <input class="files" type="file" name="doc_certificado_academico"  class="form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Registo Criminal</label>
                            <input class="files" type="file" name="doc_registo_criminal" class="form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Matricula Feita</label>
                            <input class="files" type="file" name="doc_matricula" class="form-control" id="">
                        </div>
                        
                    </div>
                    <div class="form-row mt-5 especific-saude collapse hide "  id="collapseSaude">
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Relatório Medico</label>
                            <input class="files" type="file" name="doc_relatorio_medico" class="form-control" id="">
                        </div>
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Marcação de Consulta</label>
                            <input class="files" type="file" name="doc_marcacao_de_consulta" class="form-control" id="">
                        </div>
                        
                    </div>

                    <div class="form-row mt-5 especific-trabalho collapse hide "  id="collapseTrabalho">
                        <div class="form-group col-12 col-md-3 mr-2">
                            <label for="">Contrato de Trabalho</label>
                            <input class="files" type="file" name="doc_contrato_de_trabalho" class="form-control" id="">
                        </div>
                        
                    </div>
                    <label id="filesInfo"></label>
                    <div class=" form-row mt-5">
                        <div class="form-group col-12 col-md-5">
                            <input type="submit" value="Solicitar" id="salvar"  class="w-50 btn btn-large btn-danger">
                        </div>
                    </div>
                </form>
            </div>
        </section>



        
@else



<section class="vistos w-100 container py-3 px-5 ">
            <div class="d-flex flex-column align-items-center mt-5 mb-3">
                <h3 class="font-weight-bolder">Resultado</h3>
                <hr class="bg-danger m-0 rounded" style="width: 10%;padding: 2px;">
            </div>
           
            <div class="p-3 rounded-lg border w-50 m-auto">
                <div class="p-3 rounded-lg border w-100 m-auto">
                    <div class="row">
                        <div class="col-12">
                            <i class= "text-center text-success fa-solid fa-circle-check" style="font-size: 1.5rem;"></i>
                            <h3 class="text-success font-weight-bolder text-center mb-2">Parabéns:  </h3>
                            <p class=" text-center mb-5">O seu visto foi solicitado com sucesso</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-11 m-auto ">
                            <h5 class="font-weight-bolder">Solicitante: <span class="font-weight-normal">{{session('nome')}}</span></h5>
                            <h5 class="font-weight-bolder">Destino: <span class="font-weight-normal">{{session('destino')}}</span></h5>
                            <h5 class="font-weight-bolder">Tipo: <span class="font-weight-normal text-capitalize">{{session('tipo')}}</span></h5>
                        </div>
                        <div class="col-12 m-auto ">
                            <div class="m-auto">
                                <p class="text-center">Foi enviado para o seu email [<span class="font-weight-bold">{{session('email')}}</span> ] o número do seu visto, que deverá usá-lo 
                                    para consultar o estado de sua solicitação.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="text-center mt-4 font-weight-bold">
                <a href="{{route('visas.create')}}">Voltar a solicitar</a>
            </div>
        </section>
  
@endif

@endsection
