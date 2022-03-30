
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <title>{{ config('app.name', 'Kazenergy') }}</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-align: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
        .form-signin .checkbox {
            font-weight: 400;
        }
        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>
    <body class="text-center">
         <div class="container">
             @if ($message = Session::get('error'))
                 <div class="row justify-content-center">
                     <div class="alert alert-danger" role="alert">
                         {{$message}}
                     </div>
                 </div>
             @endif
                 <form class="form-signin" action="{{route('admin.auth')}}" method="POST">
                     @csrf
                     <img class="mb-4" src="{{asset('logo.png')}}" alt="logo" width="70%">
                     <h1 class="h3 mb-3 font-weight-normal">Авторизуйтесь</h1>
                     <label for="inputEmail" class="sr-only">Email</label>
                     <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Введите Email" required>
                     <label for="inputPassword" class="sr-only">Пароль</label>
                     <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Введите Пароль" required>
{{--                     <div class="checkbox mb-3">--}}
{{--                         <label>--}}
{{--                             <input name="remember" type="checkbox" value="remember-me"> Запомнить меня--}}
{{--                         </label>--}}
{{--                     </div>--}}
                     <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
                 </form>
         </div>

    </body>
</html>
