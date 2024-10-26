@include('layout.header')

<div class="col-10 center">
    <div class="content col-12">
        <div class="container mt-4">
            <h5 style="font-weight: bold">Painel de Controle</h5>
            <p>Bem-vindo ao seu painel de controle. Aqui você pode visualizar informações importantes.</p>

            <div class="row bg-white bg-dashboard">
                <div class="col-md-6">
                    <div class="card text-primary mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <i class="fas fa-database mt-2" style="opacity: 15%;font-size: 100px"></i>
                                </div>
                                <div class="col-6 text-center">
                                    <div>
                                        <span>Total de databases</span>
                                    </div>
                                    <h3 style="font-weight: bold" class="mt-3">100</h3>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card text-primary mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <i class="fas fa-code-branch mt-2" style="opacity: 15%;font-size: 100px"></i>
                                </div>
                                <div class="col-6 text-center">
                                    <div>
                                        <span>Canais API's</span>
                                    </div>
                                    <h3 style="font-weight: bold" class="mt-3">100</h3>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

@include('layout.footer')
