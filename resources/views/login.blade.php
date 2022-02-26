<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="César Rodriguez">
        <title>Sísifo</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico">

        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        
        <!-- CSS for login page-->
        <link rel="stylesheet" href="assets/css/estilos_login.css">
    </head>
    <body id="page-top">        
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <div class="errors form-control m-3"></div>
                        <h1 class="mx-auto my-0 text-uppercase">Sísifo</h1>
                        <form name="login" action="{{ route('apiLogin') }}" method="post">
                            @csrf
                            <fieldset>
                                <input type="text" name="email" id="email" placeholder="e-mail" class="form-control m-3">
                                <input type="password" name="password" id="password" placeholder="senha" class="form-control m-3">
                            </fieldset>
                            <button type="submit" class="btn btn-primary m-3">Login
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50">
            <div class="container px-4 px-lg-5">
                <a href="mailto:{{ __('pages.adminEmail') }}">{{ __("pages.footerText") }}</a>
            </div>
        </footer>
        <script src="assets/js/login.js"></script>
    </body>
</html>