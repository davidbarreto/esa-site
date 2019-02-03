<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 03/02/19
 * Time: 18:35
 */

require_once(__DIR__.'/../model/Perfil.php');

/**
 * Verify what kind of profile is logged in
 * @see Perfil::UNLOGGED
 * @see Perfil::ADM
 * @see Perfil::USR
 * @return int Representing the kind of profile logged in
 */
function getProfileLogged() {

    if (!isset($_SESSION['perfil'])) {
        return Perfil::UNLOGGED;
    }

    return $_SESSION['perfil'];
}

/**
 * Redirect to appropriated page according to user profile
 */
function redirectToUserHomePage() {

    $profile = getProfileLogged();

    switch ($profile) {
        case Perfil::ADM:

            header("Location: ../pages/admin-profile.php");
            exit();

            break;

        case Perfil::USR:

            header("Location: ../pages/profile.php");
            exit();

            break;

        case Perfil::UNLOGGED:
        default:

            header("Location: ../static/signin.html");
            exit();

            break;
    }
}

/**
 * Prevent to unauthorized users to access pages
 * @param $pageProfile The profile that page require
 */
function checkUserAuthorization($pageProfile) {

    $profile = getProfileLogged();

    if ($profile == Perfil::UNLOGGED) {
        header("Location: ../static/signin.html");
        exit();
    }

    if ($pageProfile != $profile) {
        header('HTTP/1.0 403 Forbidden');
        exit();
    }
}

/**
 * Fill in the SESSION array with User data
 * @see Usuario
 * @param Usuario $user
 */
function fillSession(Usuario $user) {

    $_SESSION['id_usuario'] = $user->getId();
    $_SESSION['username'] = $user->getLogin();
    $_SESSION['nome'] = $user->getNome();
    $_SESSION['sobrenome'] = $user->getSobrenome();
    $_SESSION['email'] = $user->getEmail();
    $_SESSION['perfil'] = $user->getPerfil()->getId();
}