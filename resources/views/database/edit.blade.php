@include('layout.header')

<div class="col-10 center">
    <div class="content col-11">
        <div class="container mt-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <h5 style="font-weight: bold">Meu Database</h5>
            <div class="float-right">
                <button class="btn btn-primary m-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fas fa-upload"></i></button>
                <a class="btn btn-primary m-2" type="button" href="./{{$database}}/download"><i class="fas fa-download"></i></a>
                <form action="{{route('truncate.database',['database'=>$database])}}" method="post" class="form-infile">
                    @csrf
                    <button class="btn btn-warning text-white m-2" type="submit" ><i class="fas fa-server"></i></button>
                </form>
            </div>
        </div>
        <div class="bg-white bg-dashboard mt-2">
            @if($dados->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Não há registros para exibir.
                </div>
            @else
                <div class="table-responsive" style="overflow-x: scroll">
                    <table class="table mt-3" style="min-width: 100vw">
                        <thead>
                        <tr>
                            @foreach($columns as $column)
                                <th>{{ $column }}</th> <!-- ucfirst para capitalizar o primeiro caractere -->
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dados as $teste)
                            <tr>
                                @foreach($columns as $column)
                                    <td>{{ $teste->$column }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Carregar Arquivo CSV</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="#" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="arquivo" id="arquivo" class="form-control" required>
            <button class="btn btn-primary mt-3">Carregar arquivo</button>
        </form>
    </div>
</div>

@include('layout.footer')
