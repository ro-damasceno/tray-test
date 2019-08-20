<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tray test</title>

        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    </head>

    <body>

        <div id="app">
            <header>
                <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-3 nav-right">
                    <div class="container">

                        <a class="navbar-brand text-uppercase" href="/">
                            <i class="fa fa-rocket"></i> Tray
                        </a>

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Alterna navegação">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <router-link class="nav-link" to="/">Dashboard</router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>

            <main>
                <div class="container">
                    <router-view></router-view>
                </div>
            </main>

            <footer></footer>
        </div>

        <script src="{{asset ('js/app.js')}}"></script>
    </body>
</html>
