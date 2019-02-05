<?php

    require_once(__DIR__.'/../utils/functions.php');
    require_once(__DIR__.'/../utils/response-functions.php');

    session_start();

    $result = getGeneralSuccessResponse();

    if (isLoggedIn()) {
        $result = getAlreadyLoggedErrorResponse();
    } else if (isset($_POST['signupForm'])) {
        echo "call";
        $result = signup();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ESA - Criar Conta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../static/images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../static/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../static/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../static/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../static/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../static/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../static/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../static/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../static/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../static/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../static/css/util.css">
    <link rel="stylesheet" type="text/css" href="../static/css/main.css">
    <!--===============================================================================================-->
    <script src="../static/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="../static/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="../static/vendor/jquery-validation/additional-methods.min.js"></script>
    <!--===============================================================================================-->
    <script src="../static/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="../static/vendor/bootstrap/js/popper.js"></script>
    <script src="../static/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="../static/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="../static/vendor/daterangepicker/moment.min.js"></script>
    <script src="../static/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="../static/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="../static/js/main.js"></script>
    <!--===============================================================================================-->
    <script type="text/javascript">

        //Form fields validations. Using jquery-validation plugin
        $().ready(function(){

            //Setup validations
            $("#signupForm").validate({
                rules: {
                    name: "required",
                    lastname: "required",
                    username: {
                        required: true,
                        minlength: 4,
                        remote: "../functions/check_username.php"
                    },
                    pass: {
                        required: true,
                        minlength: 5
                    },
                    confirm_pass: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: "../functions/check_email.php"
                    },
                    agree: "required"
                },
                messages: {
                    name: "O Nome deve ser preenchido",
                    lastname: "O Sobrenome deve ser preenchido",
                    username: {
                        required: "O Nome de Usuário deve ser preenchido",
                        minlength: "O Nome de Usuário deve ter no mínimo 4 caracteres",
                        remote: "O Nome de Usuário escolhido já foi utilizado"
                    },
                    pass: {
                        required: "A Senha deve ser preenchida",
                        minlength: "A Senha deve ter no mínimo 5 caracteres"
                    },
                    confirm_pass: {
                        required: "A Confirmação de Senha deve ser preenchida",
                        minlength: "A Confirmação de Senha deve ter no mínimo 5 caracteres",
                        equalTo: "A Confirmação de Senha deve ser igual a Senha"
                    },
                    email: {
                        required: "O E-mail deve ser preenchido",
                        email: "E-mail em formato inválido",
                        remote: "O E-mail escolhido já foi utilizado"
                    },
                    agree: "Aceite os Termos de Uso",
                }
            });
        });
    </script>
</head>
<body style="background-color: #999999;">

<div class="limiter">
    <div class="container-login100" style="background-image: url('../static/images/bg-01.jpg');">

        <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">

            <form id="signupForm" class="login100-form validate-form" method="post" action="signup.php">

                <div class="alert alert-danger " style="<?php echo (!$result->isSuccess()) ? "display:block" : "display:none" ?>" role="alert">
                    <?php echo $result->getBusinessMessage() ?>
                </div>

                <span class="login100-form-title p-b-59">
                    ESA - Criar Conta
                </span>

                <div class="wrap-input100 validate-input">
                    <span class="label-input100">Nome</span>
                    <span class="focus-input100" data-symbol="&#xf207;"></span>
                    <input class="input100" type="text" id="name" name="name" placeholder="Maria">
                </div>

                <div class="wrap-input100 validate-input">
                    <span class="label-input100">Sobrenome</span>
                    <span class="focus-input100" data-symbol="&#xf207;"></span>
                    <input class="input100" type="text" name="lastname" placeholder="Santos">
                </div>

                <div class="wrap-input100 validate-input">
                    <span class="label-input100">E-mail</span>
                    <span class="focus-input100" data-symbol="&#xf15a;"></span>
                    <input class="input100" type="text" name="email" placeholder="Ex: maria@gmail.com">
                </div>

                <div class="wrap-input100 validate-input">
                    <span class="label-input100">Nome de Usuário</span>
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                    <input pattern=".{4,10}" class="input100" id="username" type="text" name="username" placeholder="Ex: maria1988">
                </div>

                <div class="wrap-input100 validate-input">
                    <span class="label-input100">Senha</span>
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                    <input id="password" class="input100" type="password" name="pass" placeholder="Digite sua Senha">
                </div>

                <div class="wrap-input100 validate-input">
                    <span class="label-input100">Repetir a Senha</span>
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                    <input class="input100" type="password" name="confirm_pass" placeholder="Digite sua senha novamente">
                </div>

                <div class="flex-m w-full p-b-33">
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="agree">
                        <label class="label-checkbox100" for="ckb1">
								<span class="txt1">
									Eu concordo com os
									<a href="#" class="txt2 hov1">
										Termos de Uso
									</a>
								</span>
                        </label>
                    </div>
                </div>

                <input type="hidden" name="signupForm" value="1">

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn">
                            Criar Conta
                        </button>
                    </div>

                    <a href="signin.php" class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30">
                        Já tem um login?
                        <i class="fa fa-long-arrow-right m-l-5"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>