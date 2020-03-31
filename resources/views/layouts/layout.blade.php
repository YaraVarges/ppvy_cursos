<html>
    <head>
        <title>PPVY Cursos - @yield('title')</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div class="container-fluid">
            <header>
                @section('header')
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <a class="navbar-brand" href="/">PPVY Cursos</a>
                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown-cursos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Cursos
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdown-cursos">
                                    <a class="dropdown-item" href="{{ @route('cursos_lista') }}">Listagem</a>
                                    <a class="dropdown-item" href="{{ @route('cursos_criar') }}">Criação</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown-matriculas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Matrículas
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdown-matriculas">
                                    <a class="dropdown-item" href="{{ @route('matriculas_lista_por_aluno') }}">Listagem</a>
                                    <a class="dropdown-item" href="{{ @route('matriculas_realizar_matricula') }}">Realizar matrícula</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                @show
            </header>

            @yield('content')

            <footer class="footer page-footer bg-dark text-white fixed-bottom">
                <div class="text-center py-3">© 2020 Copyright: PPVY Cursos
                </div>
            </footer>

        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
