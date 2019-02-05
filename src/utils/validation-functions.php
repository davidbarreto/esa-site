<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 04/02/19
 * Time: 22:47
 */

require_once(__DIR__.'/../dao/CidadeDAO.php');
require_once(__DIR__.'/../dao/EstadoDAO.php');
require_once(__DIR__.'/../dao/UsuarioDAO.php');

function isEmpty($var) {
    return (null === $var or !isset($var) or empty($var));
}

function isPostalCodeValid($postalCode) {
    return preg_match('/[0-9]{5}-[0-9]{3}/', $postalCode);
}

function isTelephoneValid($tel) {
    return preg_match('/\([0-9]{2}\)[0-9]{5}-[0-9]{4}/', $tel);
}

function existsState($id) {
    return EstadoDAO::getInstance()->existsStateId($id);
}

function isCityBelongingToState($cityId, $stateId) {
    return CidadeDAO::getInstance()->existsCityInState($cityId, $stateId);
}

function isUsernameValid($username) {
    return strlen($username) >= 4;
}

function isUsernameAlreadyUsed($username) {
    return UsuarioDAO::getInstance()->existsUser($username);
}

function isEmailAlreadyUsed($email) {
    return UsuarioDAO::getInstance()->existsEmail($email);
}

function isEmailValid($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}