@extends('portal.layout.template')
@section('title','Vistos ')


@section('content')



<section class="vistos w-100 container py-3">
            <div class="d-flex flex-column align-items-center mb-3">
                <h1 class="font-weight-bolder">Vistos</h1>
                <hr class="bg-danger m-0 rounded" style="width: 5%;padding: 2px;">
                <p class="mt-2">A partir da plataforma poderá solicitar aos mais variados vistos disponíveis</p>
            </div>

            <div>

                <div class="accordion" id="accordionExample">
                    <div class="card">
                      <div class="card-header bg-danger" id="headingOne">
                        <h2 class="mb-0 ">
                          <button class="btn text-white btn-danger  btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Visto de Estudo <i class="ml-2  fa fa-chevron-down" style="font-size: 0.7rem;"></i>
                          </button>
                        </h2>
                      </div>
                  
                      <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body px-5">
                          <p>
                            O visto de estudo é concedido ao cidadão, pelas Missões diplomáticas e consulares angolanas 
                            a fim de frequentar um programa de estudos em escolas públicas ou privadas, 
                            assim como em centros de formação profissional. 
                          </p>
                          <div>
                                <h5 class="font-weight-bolder">Requisitos</h5>
                                <ul style="list-style-type: disc !important ;">
                                    <li>Cópia do BI e Passaporte</li>
                                    <li>(3) Fotos tipo passe</li>
                                    <li>Declaração de Serviço</li>
                                    <li>Recibos de Salário</li>
                                    <li>Certificado Acadêmico</li>
                                    <li>Contrato de arrendamento</li>
                                    <li>Seguro de Viagem(minimo 3 meses)</li>
                                    <li>Registo Criminal</li>
                                    <li>Extracto Bancário</li>
                                    <li>Matrícula Feita (no país destino)</li>
                                </ul>
                          </div>
                          <div>
                            <a href="{{route('visas.create')}}" class="btn btn-large btn-dark ml-3">Solicitar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header bg-danger" id="headingTwo">
                        <h2 class="mb-0">
                          <button class="btn  btn-danger text-white btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Visto Saúde <i class="ml-2  fa fa-chevron-down" style="font-size: 0.7rem;"></i>
                          </button>
                        </h2>
                      </div>
                      <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <p>
                            O visto de saúde é concedido pelas Missões diplomáticas e consulares angolanas 
                            ao cidadão e destina-se permite a entrada do seu titular em Angola, 
                            a fim de efectuar tratamento em unidade hospitalar público ou privada.
                            </p>
                            <div>
                                <h5 class="font-weight-bolder">Requisitos</h5>
                                <ul style="list-style-type: disc !important ;">
                                    <li>Cópia do BI e Passaporte</li>
                                    <li>(3) Fotos tipo passe</li>
                                    <li>Declaração de Serviço</li>
                                    <li>Recibos de Salário</li>
                                    <li>Relatório Médico</li>
                                    <li>Contrato de arrendamento</li>
                                    <li>Seguro de Viagem(minimo 3 meses)</li>
                                    <li>Extracto Bancário</li>
                                    <li>Marcação da Consulta (no país destino)</li>
                                </ul>
                            </div>
                            <div>
                                <a href="{{route('visas.create')}}" class="btn btn-large btn-dark ml-3">Solicitar</a>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header bg-danger" id="headingThree">
                        <h2 class="mb-0">
                          <button class="btn  btn-danger text-white btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Visto de Trabalho <i class="ml-2  fa fa-chevron-down" style="font-size: 0.7rem;"></i>
                          </button>
                        </h2>
                      </div>
                      <div id="collapseThree" class="collapse " aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <p>
                            O visto de trabalho é concedido pelas Missões diplomáticas e consulares angolanas a fim de exercer temporariamente uma 
                            actividade profissional remunerada no interesse do Estado ou por conta de outrem.
                            </p>
                            <div>
                                <h5 class="font-weight-bolder">Requisitos</h5>
                                <ul style="list-style-type: disc !important ;">
                                    <li>Cópia do BI e Passaporte</li>
                                    <li>(3) Fotos tipo passe</li>
                                    <li>Declaração de Serviço</li>
                                    <li>Recibos dos ultimos Salário</li>
                                    <li>Certificado Acadêmico</li>
                                    <li>Contrato de arrendamento</li>
                                    <li>Extracto Bancário</li>
                                    <li>Pré-contrato de trabalho ou Contrato de trabalho</li>
                                </ul>
                            </div>
                            <div>
                                <a href="{{route('visas.create')}}" class="btn btn-large btn-dark ml-3">Solicitar</a>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </section>
            



@endsection