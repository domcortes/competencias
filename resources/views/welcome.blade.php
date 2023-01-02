<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <title>{{ env('APP_NAME') }}</title>
        <style>
            .nav-link {
                color: white;
            }
        </style>
    </head>
    <body style="background-color: black">
        <nav class="navbar navbar-expand-lg" style="background-color: black">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Competencia" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                @auth
                    <a href="{{ url('/home') }}" class="nav-link">Mi panel</a>
                @else
                    <div class="dropdown show">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Registar
                        </a>
                        <div class="dropdown-menu bg-gradient-dark" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('atletas.register') }}">Atletas</a>
                            <a class="dropdown-item" href="{{ route('register') }}">Organizadores</a>
                        </div>
                    </div>
                    <a href="{{ route('login') }}" class="nav-link">Iniciar sesion</a>
                @endauth
            </form>
        </div>
    </nav>
        <div class="container" >
            <br>
            <div class="row">
                <div class="col text-center presentation-text">Listado de competencias disponibles</div>
            </div>
            <hr>
            <div class="row">
                @foreach($competencias as $competencia)
                    <div class="col-4 mb-4">
                        <div class="card border-secondary" style="width: 18rem; display: none" id="card-{{$competencia->id}}">
                            <img src="https://picsum.photos/200/150" class="card-img-top" alt="...">
                            <div class="card-body bg-dark text-white">
                                <h5 class="card-title text-center">
                                    {{ ucwords($competencia->nombre_competencia) }}
                                    <br>
                                    @if($competencia->termino_inscripciones === \Carbon\Carbon::now()->format('Y-m-d'))
                                        <span class="badge bg-danger text-white">¡Último dia inscripcion!</span>
                                    @endif
                                    @if($competencia->termino_inscripciones < \Carbon\Carbon::now()->format('Y-m-d'))
                                        <span class="badge bg-info text-white">Inscripciones cerradas</span>
                                    @endif

                                </h5>
                                <p class="card-text text-center">
                                    Inicio competencia: <strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $competencia->fecha_inicio)->format('d/m/y') }}</strong>
                                    Término competencia <strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $competencia->fecha_termino)->format('d/m/y') }}</strong>
                                </p>
                            </div>
                            <div class="card-footer bg-dark border-0">
                                <a href="" class="btn btn-block btn-primary">¡Quiero inscribirme!</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        <script>
            setTimeout(() => {
                @foreach($competencias as $competencia)
                    $('#card-{{$competencia->id}}').fadeIn(3500)
                @endforeach
            }, 1000)

        </script>
    </body>
</html>
