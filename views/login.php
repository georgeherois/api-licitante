<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Yinka Enoch Adedokun">
    <link rel="shortcut icon" type="image/jpg" href="<?php echo BASE_URL; ?>assets/img/favicon.ico" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css">
    <title>Login</title>


</head>

<body>

    <div id="main-wrapper" class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="mb-5">
                                        <h3 class="h4 font-weight-bold text-theme"></h3>
                                    </div>

                                    <!--<h6 class="h5 mb-0">Welcome back!</h6>-->
                                    <p class="text-muted mt-2 mb-5"><img src="<?php echo BASE_URL; ?>assets/img/logo-card.png" class="rounded mx-auto d-block" alt="..."></p>

                                    <form action="<?php BASE_URL; ?>home" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Digite o E-mail </label>
                                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" required>
                                        </div>
                                        <div class="form-group mb-5">
                                            <label for="exampleInputPassword1">Digite a senha</label>
                                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg" style="width:120px;">Entrar</button>
                                        <!--<a href="#l" class="forgot-link float-right text-primary">Forgot password?</a>-->
                                    </form>
                                    <?php echo (!empty($error)) ? $error : ""; ?>
                                </div>

                            </div>

                            <div class="col-lg-6 d-none d-lg-inline-block">
                                <div class="account-block rounded-right">
                                    <div class="overlay rounded-right"></div>
                                    <div class="account-testimonial">
                                        <h4 class="text-white mb-4"><img src="<?php echo BASE_URL; ?>assets/img/logo.png" width="300" height="90" alt="..."></h4>
                                        <p class="lead text">O Principal objetivo do sistema Licitante Exxpert é unificar as informações sobre licitações e contratos em um único ambiente, facilitando o acesso para órgãos públicos, fornecedores e cidadãos.</p>
                                        <p>- Desenvolvido por Sofdev -</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->

                <!--<p class="text-muted text-center mt-3 mb-0">Don't have an account? <a href="" class="text-primary ml-1">register</a></p>-->

                <!-- end row -->

            </div>
            <!-- end col -->
        </div>
        <!-- Row -->
    </div>



</body>

</html>