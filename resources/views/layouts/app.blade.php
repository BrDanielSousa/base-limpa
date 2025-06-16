<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Carteira Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            width: 220px;
            background-color: #343a40;
        }

        .sidebar a {
            color: #fff;
            padding: 15px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #495057;
            text-decoration: none;
        }

        .main {
            margin-left: 220px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-white text-center mt-3">Menu</h4>

        <a href="{{ route('dashboard') }}">
            <i class="bi bi-wallet2 me-2"></i> Dashboard
        </a>

        <a href="{{ route('deposito.create') }}">
            <i class="bi bi-arrow-down-circle me-2"></i> Depósito
        </a>

        <a href="{{ route('transferencia.create') }}">
            <i class="bi bi-send me-2"></i> Transferir
        </a>

        <form action="{{ route('logout') }}" method="POST" class="d-block">
            @csrf
            <button type="submit" class="btn btn-link text-white text-start w-100 px-3">
                <i class="bi bi-box-arrow-right me-2"></i> Sair
            </button>
        </form>
    </div>


    <!-- Conteúdo principal -->
    <div class="main">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
        @endif
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>