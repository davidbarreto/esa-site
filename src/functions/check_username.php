<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 26/01/19
 * Time: 15:23
 */

    require_once(__DIR__.'/../dao/UsuarioDAO.php');

    $username = isset($_GET['username']) ? $_GET['username'] : '';

    if (!empty($username)) {

        $result = UsuarioDAO::getInstance()->existsUsuario($username);

        if ($result) {
            echo "false";
        } else {
            echo "true";
        }
    }