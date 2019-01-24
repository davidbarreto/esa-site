<?php
    require_once(__DIR__.'/../dao/EstadoDAO.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Encontrinho Secreto das Amigas - Cadatro de Sócia</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" id="bootstrap-css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            <!-- Carrega as Cidades -->
            $('#uf').change(function(e){
                var estado = $('#uf').val();

                Reset();
                $.getJSON('../functions/carrega_municipios.php?id_uf='+estado, function (dados){
                    if (dados.length > 0){
                        var option = '<option>Selecione a Cidade</option>';
                        $.each(dados, function(i, obj){
                            option += '<option value='+ obj.id_cidade + '>'+obj.nome_cidade + '</option>';
                        })
                    }
                    $('#cidade').html(option).show();
                })
            });

            <!-- Resetar Selects -->
            function Reset(){
                $('#cidade').empty().append('<option>Selecione Estado para Carregar a lista</option>');
            }
        });
    </script>
</head>
<body>

<div class="container">
    <form class="well form-horizontal" action="../functions/cadastra_socio.php" method="post">
        <fieldset>
            <div class="form-group">
                <label class="col-md-4 control-label">Nome Completo</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i
                                class="glyphicon glyphicon-user"></i></span>
                        <input class="form-control" id="fullName"
                               name="nomecompleto"
                               placeholder="Ex: Maria da Silva Santos"
                               required="true" type="text"
                               value=""></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Data de Nascimento</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i
                                    class="glyphicon glyphicon-user"></i></span>
                        <input class="form-control" id="datanascimento"
                               name="datanascimento"
                               placeholder="Ex: 25/12/1990"
                               required="true" type="date"
                               value=""></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Logradouro</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i
                                class="glyphicon glyphicon-home"></i></span>
                        <input class="form-control"
                               id="logradouro"
                               name="logradouro"
                               placeholder="Ex: Av. Paulista"
                               required="true" type="text"
                               value=""></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Número</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i
                                    class="glyphicon glyphicon-home"></i></span>
                        <input class="form-control"
                               id="numero_residencia"
                               name="numero_residencia"
                               placeholder="Ex: 1578"
                               required="true" type="number"
                               value=""></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Complemento</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i
                                    class="glyphicon glyphicon-home"></i></span>
                        <input class="form-control"
                               id="complemento"
                               name="complemento"
                               placeholder="Ex: Apt. 102"
                               required="true" type="text"
                               value=""></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Bairro</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i
                                    class="glyphicon glyphicon-home"></i></span>
                        <input class="form-control"
                               id="bairro"
                               name="bairro"
                               placeholder="Ex: Bela Vista"
                               required="true" type="text"
                               value=""></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Estado</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i
                                    class="glyphicon glyphicon-home"></i></span>
                        <select class="form-control" id="uf"
                                  name="uf"
                                  required="true">

                            //Get the states and populate the options

                            <?php
                                $estados = EstadoDAO::getInstance()->getListaEstados();

                                echo "<option value='0'>Selecione seu Estado</option>";

                                foreach ($estados as $e) {
                                    $id = $e->getId();
                                    $sigla = $e->getUf();
                                    echo "<option value='$id'>$sigla</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Cidade</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i
                                class="glyphicon glyphicon-home"></i></span>
                        <select class="form-control" id="cidade"
                               name="cidade"
                               required="true">
                            <option value="0">Selecione Estado para Carregar a lista</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">CEP</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i
                                class="glyphicon glyphicon-home"></i></span>
                        <input class="form-control" id="cep"
                               name="cep"
                               placeholder="CEP"
                               required="true" type="text"
                               value=""></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">E-mail</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i
                                class="glyphicon glyphicon-envelope"></i></span>
                        <input class="form-control" id="email"
                               name="email"
                               placeholder="E-mail"
                               required="true" type="text"
                               value=""></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Whatsapp</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i
                                class="glyphicon glyphicon-earphone"></i></span>
                        <input class="form-control"
                               id="telefone"
                               name="telefone"
                               placeholder="11999999999"
                               required="true" type="text"
                               value=""></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <input class="form-control"
                               id="enviar"
                               name="enviar"
                               type="submit"
                               value="Enviar"></div>
                </div>
            </div>
        </fieldset>
    </form>
</div>
</body>
</html>