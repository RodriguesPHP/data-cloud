@include('layout.header')

<div class="col-10 center">
    <div class="content col-10">
        <div class="container mt-4">
            <h5 style="font-weight: bold">Meus Databases</h5>
            <p>Aqui você pode visualizar informações importantes e configuração seus databases</p>
            <div class="float-right">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fas fa-circle-plus"></i>Criar um database</button>
            </div>
        </div>
        <div class="bg-white bg-dashboard mt-2">
            @if($databases->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Não há registros para exibir.
                </div>
            @else
                @foreach($databases as $database)
                <div class="row col-12 mt-3 databases">
                    <div class="col-1">
                        <div class="bg-img center">
                            <i class="fas fa-database fs-2 mt-3"></i>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="fs-5 fw-bold">{{$database->name}}</div>
                        <div>{{$database->uuid}}</div>
                    </div>

                    <div class="col-4 center">
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-outline-primary" href="{{route('view.database',['database'=>$database->uuid])}}"><i class="fas fa-eye"></i></a>
                            </div>
                            <div class="col">
                                <button class="btn btn-outline-primary" onclick="copy('{{$database->uuid}}')"><i class="fas fa-link"></i></button>
                            </div>
                            <div class="col">
                                <a class="btn btn-outline-success" href="{{route('exportar.database',['database'=>$database->uuid])}}"><i class="fas fa-download"></i></a>
                            </div>
                            <div class="col">
                                <form action="{{route('delete.database',['database'=>$database->uuid])}}" method="post">
                                    @csrf
                                    <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" style="min-width: 800px" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Novo Database</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @include('database.create')
    </div>
</div>

<script>
    function copy(uuid) {
        const host = window.location.host;
        const url = `https://${host}/api/${uuid}/query?pass=&column=&value=`;

        navigator.clipboard.writeText(url).then(() => {
            console.log('URL copiada para a área de transferência:', url);
        }).catch(err => {
            console.error('Erro ao copiar a URL:', err);
        });
    }
</script>

@include('layout.footer')
