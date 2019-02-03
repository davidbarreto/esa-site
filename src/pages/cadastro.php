<?php
    require_once(__DIR__.'/../dao/EstadoDAO.php');
    session_start();

    function printVar($index) {
        if (isset($_SESSION[$index])) {
            echo $_SESSION[$index];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ESA - Criar Cadastro de Sócia</title>
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

    <!-- Script to load cities from state chose -->
    <script type="text/javascript">
        $().ready(function(){
            <!-- Carrega as Cidades -->
            $('#state').change(function(e){
                var estado = $('#state').val();

                Reset();
                $.getJSON('../functions/carrega_municipios.php?id_uf='+estado, function (dados){
                    if (dados.length > 0){
                        var option = "<option value=''>Selecione a Cidade</option>";
                        $.each(dados, function(i, obj){
                            option += "<option value='"+ obj.id_cidade + "'>" + obj.nome_cidade + "</option>";
                        })
                    }
                    $('#city').html(option).show();
                })
            });

            //Form fields validations. Using jquery-validation plugin

            //Setup validations
            $("#signupForm").validate({
                rules: {
                    birthday: "required",
                    address: "required",
                    state: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    cep: {
                        required: true,
                        pattern: /^[0-9]{5}-[0-9]{3}$/
                    },
                    telephone: {
                        pattern: /^\([0-9]{2}\)[0-9]{4}[0-9]?-[0-9]{4}$/
                    }
                },
                messages: {
                    birthday: "A data de nascimento deve ser preenchida",
                    address: "O logradouro deve ser preenchido",
                    state: "O Estado deve ser preenchido",
                    city: "A Cidade deve ser preenchida",
                    cep: {
                        required: "O CEP deve ser preencido",
                        pattern: "O formato do CEP está incorreto"
                    },
                    telephone: {
                        required: "A Senha deve ser preenchida",
                        pattern: "O formato do número de WhatsApp está incorreto"
                    }
                }
            });
        });

        //Function to verify User field in server, by calling a GET Method
        function verifyField(type, value) {

            let response = false;

            $.ajax({
                url: '../functions/valida_usuario.php',
                type: 'get',
                data: {
                    type: type,
                    value: value
                },
                dataType: 'html',
                async: false,
                success: function(data) {
                    response = (data != 0) ? true : false;
                }
            });

            return response;
        }

        //Reset Cities
        function Reset(){
            $('#city').empty().append('<option>Selecione Estado para Carregar a lista</option>');
        }
    </script>
</head>
<body style="background-color: #999999;">

<div class="limiter">
    <div class="container-login100" style="background-image: url('../static/images/bg-01.jpg');">

        <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
            <form id="signupForm" class="login100-form validate-form" method="post" action="../functions/cadastra_socio.php">
					<span class="login100-form-title p-b-59">
						ESA - Criar Conta: Complete seu Cadastro para ser Sócia!
					</span>

                <div class="wrap-input100">
                    <span class="label-input100">Nome</span>
                    <input class="input100" type="text" name="name" placeholder="Ex: Maria"
                           value="<?php printVar('nome'); ?>" readonly>
                    <span class="focus-input100" data-symbol="&#xf207;"></span>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100">Sobrenome</span>
                    <input class="input100" type="text" name="lastname" placeholder="Ex: Santos"
                           value="<?php printVar('sobrenome'); ?>" readonly>
                    <span class="focus-input100" data-symbol="&#xf207;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "O E-mail deve ser válido: ex@abc.xyz">
                    <span class="label-input100">E-mail</span>
                    <input class="input100" type="text" name="email" placeholder="Ex: maria@gmail.com"
                           value="<?php printVar('email'); ?>" readonly>
                    <span class="focus-input100" data-symbol="&#xf15a;"></span>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100">Data de Nascimento</span>
                    <input class="input100" type="date" name="birthday" placeholder="Digite sua Data de Nascimento">
                    <span class="focus-input100" data-symbol="&#xf122"></span>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100">Logradouro</span>
                    <input class="input100" type="text" name="address" placeholder="Ex: Av. Paulista">
                    <span class="focus-input100" data-symbol="&#xf175"></span>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100">Número</span>
                    <input class="input100" type="text" name="number" placeholder="Ex: 1578">
                    <span class="focus-input100" data-symbol="&#xf175"></span>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100">Complemento</span>
                    <input class="input100" type="text" name="address2" placeholder="Ex: Apt. 102">
                    <span class="focus-input100" data-symbol="&#xf175"></span>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100">Bairro</span>
                    <input class="input100" type="text" name="neighborhood" placeholder="Ex: Boa Vista">
                    <span class="focus-input100" data-symbol="&#xf175"></span>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100">Estado</span>

                    <select class="form-control" id="state"
                            name="state"
                            required="true">

                        <?php

                            //Get the states and populate the options
                            $estados = EstadoDAO::getInstance()->getListaEstados();
                            echo "<option value=''>Selecione seu Estado</option>";

                            foreach ($estados as $e) {
                                $id = $e->getId();
                                $sigla = $e->getUf();
                                echo "<option value='$id'>$sigla</option>";
                            }
                        ?>
                    </select>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100">Cidade</span>

                    <select class="form-control" id="city"
                            name="city"
                            required="true">
                        <option value="">Selecione Estado para Carregar a lista</option>
                    </select>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100">CEP</span>
                    <input class="input100" type="text" name="cep" placeholder="Ex: 01310-200">
                    <span class="focus-input100" data-symbol="&#xf175"></span>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100">Whatsapp</span>
                    <input class="input100" type="tel" name="telephone" placeholder="Ex: (11)97777-7777">
                    <span class="focus-input100" data-symbol="&#xf405;"></span>
                </div>

                <div class="flex-m w-full p-b-33">
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn">
                            Criar Cadastro de Socia!
                        </button>
                    </div>

                    <a href="../static/signin.html" class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30">
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