<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 24/01/19
 * Time: 00:57
 */

    require_once(__DIR__.'/../dao/UsuarioDAO.php');
    require_once(__DIR__.'/../model/Usuario.php');

    session_start();

    $nome = $_POST['name'];
    $sobrenome = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $repeated = $_POST['repeat-pass'];

    //TODO Basic validations
    if ($pass !== $repeated) {

        header('Location: ../static/signup.html');
    }

    //Generate Hashed Password
    $hash_password = password_hash($pass, PASSWORD_DEFAULT);

    $usuario = new Usuario();
    $usuario->setLogin($username);
    $usuario->setSenha($hash_password);
    $usuario->setEmail($email);
    $usuario->setNome($nome);
    $usuario->setSobrenome($sobrenome);

    //This user gonna be regular user
    $perfil = new Perfil();
    $perfil->setId(Perfil::USR);
    $usuario->setPerfil($perfil);

    $result = UsuarioDAO::getInstance()->insertUsuario($usuario);

    if ($result->isSucess()) {

        $_SESSION['id_usuario'] = $result->getData();
        $_SESSION['username'] = $username;
        $_SESSION['nome'] = $nome;
        $_SESSION['sobrenome'] = $sobrenome;
        $_SESSION['email'] = $email;
        $_SESSION['perfil'] = $perfil->getId();

        header("Location: ../pages/cadastro.php");

    } else {
        echo $result->getStatusMessage();
    }




