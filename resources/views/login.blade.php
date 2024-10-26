@include('layout.header')
<div class="col-10 center">
    <div class="content col-10">
        <div class="container mt-4">
            <h1 style="font-weight: bold">Login</h1>
            <p>Bem-vindo ao seu painel de controle. Aqui você pode visualizar informações importantes.</p>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row bg-white bg-dashboard">
                <form action="#" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">Nunca compartilharemos seu e-mail com mais ninguém.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Logar</button>
                </form>
            </div>
        </div>


    </div>
</div>
@include('layout.footer')
