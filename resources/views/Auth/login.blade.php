<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-scheme="night">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <meta name="description" content="The login page allows a user to gain access to an application by entering their username and password or by authenticating using a social media login.">
    <title>Login | Cogelo</title>
    <link rel="icon" type="image/svg" sizes="32x32" href="{{ asset('img/favicon.ico') }}">

    <!-- STYLESHEETS -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--- -->

    <!-- Fonts [ OPTIONAL ] -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS [ REQUIRED ] -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

    <!-- Nifty CSS [ REQUIRED ] -->
    <link rel="stylesheet" href="{{ asset('assets/css/nifty.min.css') }}">

    <!-- Nifty Demo Icons [ OPTIONAL ] -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo-purpose/demo-icons.min.css') }}">
</head>

<body class="">

    <!-- PAGE CONTAINER -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div id="root" class="root front-container">
        <div style="grid-area:2/1/2/2;" class="d-flex justify-content-center m-3">
            <div>
                <img style="width:100px;vertical-align:middle;" src="{{ asset('img/logo.png') }}" />
            </div>
        </div>
        <!-- CONTENTS -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <section id="content" class="content">
            <div class="content__boxed w-100 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <div class="content__wrap">
                    <!-- Login card -->
                    <div class="card shadow-lg">
                        <div class="card-header">
                            @include('includes.flash-message')
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <h1 class="h3">Connexion</h1>
                                <p>Connectez vous a votre compte</p>
                            </div>

                            <form class="mt-4" method="POST" action="/login">
                                @csrf
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email" autofocus>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="d-grid mt-5">
                                    <button class="btn btn-primary btn-lg" type="submit">Se connecter</button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- END : Login card -->

                </div>
            </div>
        </section>

        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - CONTENTS -->
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - PAGE CONTAINER -->


    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - BOXED LAYOUT : BACKGROUND IMAGES CONTENT [ DEMO ] -->
    <!-- JAVASCRIPTS -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

    <!-- Popper JS [ OPTIONAL ] -->
    <script src="./assets/vendors/popperjs/popper.min.js" defer></script>

    <!-- Bootstrap JS [ OPTIONAL ] -->
    <script src="./assets/vendors/bootstrap/bootstrap.min.js" defer></script>

    <!-- Nifty JS [ OPTIONAL ] -->
    <script src="./assets/js/nifty.js" defer></script>

    <!-- Nifty Settings [ DEMO ] -->
    <script src="./assets/js/demo-purpose-only.js" defer></script>

</body>

</html>
