<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/6b4ddefc79.js" crossorigin="anonymous"></script>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        html,body{
            height: 100% !important;
    }
    </style>
</head>
<body  style="background-image: url('img/viagem.jpeg');background-position: center;background-size: cover;">
<div class="w-100" style="background-color: rgba(0,0,0,0.7);height: inherit;">

<div class="container">

<div class="row">
    <div class="mb-5"></div>
    <div class="col-10 col-md-7 col-lg-4 m-auto bg-white p-5 border rounded mt-5">
        <div class="logo mt-2 d-flex flex-column justify-content-center align-items-center">
            <i class="far fa-paper-plane" style="font-size: 2rem;"></i>    
            <h4 style="font-size: 1.5rem">PDC Airlines</h4>
        </div>
        <div class="mt-3">
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="d-flex flex-column">
                    <div class="form-group mb-4">
                        <label for="email" class="mb-2">Seu Email</label>
                        <div class="">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            >
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password" class="">Sua Senha</label>
                        <div class="">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="current-password"
                            >

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="">
                            <button type="submit" class="btn btn-primary w-100">
                                Entrar
                            </button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Esqueceu sua Senha?
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    
</div>






</div>

</body>
</html>
