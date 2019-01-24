<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 22/01/19
 * Time: 22:07
 */

    require_once(__DIR__.'/../dao/SocioDAO.php');
    require_once(__DIR__.'/../model/Socio.php');
    require_once(__DIR__.'/../model/Cidade.php');

    //Obtem campos
    $nome_completo = $_POST["nomecompleto"];
    $data_nascimento = $_POST["datanascimento"];
    $logradouro = $_POST["logradouro"];
    $numero_residencia = $_POST["numero_residencia"];
    $complemento= $_POST["complemento"];
    $bairro = $_POST["bairro"];
    $id_estado = $_POST["uf"];
    $id_cidade = $_POST["cidade"];
    $cep = $_POST["cep"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];

    //Valida Campos
    //TODO Validar campos

    //Preenche objeto de Modelo
    $socio = new Socio();

    $socio->setNomeCompleto($nome_completo);
    $socio->setDataNascimento($data_nascimento);
    $socio->setLogradouro($logradouro);
    $socio->setNumResidencia($numero_residencia);
    $socio->setComplementoEndereco($complemento);
    $socio->setBairro($bairro);

    $cidade = new Cidade();
    $cidade->setId($id_cidade);
    $socio->setCidade($cidade);

    $socio->setCep($cep);
    $socio->setEmail($email);

    //TODO setWhasapp

    SocioDAO::getInstance()->insertSocio($socio);


