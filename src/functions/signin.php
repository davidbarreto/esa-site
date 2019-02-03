<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 23/01/19
 * Time: 22:56
 */

    require_once(__DIR__.'/../dao/UsuarioDAO.php');
    require_once(__DIR__.'/../model/Usuario.php');
    require_once(__DIR__.'/../model/Perfil.php');
    require_once(__DIR__.'/../utils/functions.php');

    session_start();

    //TODO Use captcha

    $username = $_POST['username'];
    $pass = $_POST['pass'];

    $usuario = UsuarioDAO::getInstance()->getUsuarioByUsernameOrEmail($username);

    if (null !== $usuario) {

        $verified = password_verify($pass, $usuario->getSenha());

        //Test $pass against the password hash stored to this user in database
        if ($verified) {

            //User logged in
            echo "Login OK";

            fillSession($usuario);
            redirectToUserHomePage();

        } else {

            //TODO return error page
            echo "Senha incorreta";
            session_destroy();
        }
    }
    else {

        //TODO return error page
        echo "Usuario ou Senha incorretos";
        session_destroy();
    }

