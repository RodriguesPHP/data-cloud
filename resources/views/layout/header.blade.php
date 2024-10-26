<!doctype html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Base Info</title>

    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<style>
    body{
        background-color: rgba(89, 97, 102, 0.19);
        font-family: Roboto;
    }
    .sidebar {
        height: 100vh;
        padding-top: 20px;
        width: 300px;
        border-right: 1px solid rgba(151, 151, 151, 0.62);
    }

    .navbar{
        border-bottom: 1px solid rgba(151, 151, 151, 0.62);
    }

    .float-right {
        display: flex;
        justify-items: right;
        justify-content: right;
    }

    .nav-link {
        color: black;
        font-size: 14px;
        font-weight: bold;
        padding-top:10px;
    }
    .active {
        color: var(--bs-link-color) !important;
        background-color: rgba(0, 89, 255, 0.14);
        border-radius: 3px;
    }
    .fas {
        font-size: 14px;
        margin-right: 3px;
    }
    .center {
        display: flex;
        justify-content: center;
    }
    .bg-dashboard{
        padding: 30px;
        border-radius: 10px;
    }
    .card{
        border:none !important;
    }

    .bg-img{
        background-color: rgba(47, 100, 239, 0.41);
        border-radius: 100%;
        height: 70px;
        width: 70px;
        color: white;
        justify-self: center;
        justify-items: center;
    }

    .databases{
        display: flex;
        justify-content: center;
        align-items: center;

    }
</style>
<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{asset('logo.png')}}" alt="Logo" class="d-inline-block align-text-top">
        </a>
        <div style="float: right">
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button class="btn" type="submit"><i class="fas fa-sign-out-alt"></i></button>

            </form>
        </div>
    </div>


</nav>

<div class="d-flex">
    <div class="sidebar bg-light p-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{route('dashboard')}}">
                    <i class="fas fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('database') ? 'active' : '' }}" href="{{ route('database') }}">
                    <i class="fas fa-database"></i> Bancos de Dados
                </a>
            </li>
        </ul>
    </div>


