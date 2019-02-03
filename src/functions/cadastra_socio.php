<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 22/01/19
 * Time: 22:07
 */

    require_once(__DIR__.'/../dao/SocioDAO.php');
    require_once(__DIR__.'/../dao/UsuarioDAO.php');
    require_once(__DIR__.'/../model/Socio.php');
    require_once(__DIR__.'/../model/Cidade.php');

    session_start();

    //Obtem campos
    $nome = $_POST["name"];
    $sobrenome = $_POST["lastname"];
    $email = $_POST["email"];
    $data_nascimento = $_POST["birthday"];
    $logradouro = $_POST["address"];
    $numero_residencia = $_POST["number"];
    $complemento= $_POST["address2"];
    $bairro = $_POST["neighborhood"];
    $id_estado = $_POST["state"];
    $id_cidade = $_POST["city"];
    $cep = $_POST["cep"];
    $telefone = $_POST["telephone"];

    //Valida Campos
    //TODO Validar campos

    //Preenche objeto de Modelo
    $socio = new Socio();

    $socio->setDataNascimento($data_nascimento);
    $socio->setLogradouro($logradouro);
    $socio->setNumResidencia($numero_residencia);
    $socio->setTelefone($telefone);
    $socio->setComplementoEndereco($complemento);
    $socio->setBairro($bairro);

    $cidade = new Cidade();
    $cidade->setId($id_cidade);
    $socio->setCidade($cidade);

    $socio->setCep($cep);

    //TODO setWhasapp

    $resultSocio = SocioDAO::getInstance()->insertSocio($socio);

    if ($resultSocio->isSucess()) {

        $id_socio = $resultSocio->getData();
        $id_usuario = $_SESSION["id_usuario"];

        $_SESSION["id_socio"] = $id_socio;

        $resultUsuario = UsuarioDAO::getInstance()->updateSocioId($id_usuario, $id_socio);

        if ($resultSocio->isSucess()) {
            echo "OK";
        } else {
            echo "NOK";
        }

    }


