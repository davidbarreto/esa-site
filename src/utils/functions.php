<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 03/02/19
 * Time: 18:35
 */

require_once(__DIR__.'/../dao/SocioDAO.php');
require_once(__DIR__.'/../dao/UsuarioDAO.php');
require_once(__DIR__.'/../model/Perfil.php');
require_once(__DIR__.'/../model/Socio.php');
require_once(__DIR__.'/../model/Cidade.php');

require_once(__DIR__.'/Response.php');
require_once(__DIR__.'/messages.php');
require_once(__DIR__.'/response-functions.php');
require_once(__DIR__.'/validation-functions.php');

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

function isLoggedIn() {
    return isset($_SESSION['id_usuario']);
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

            header("Location: ../pages/signin.php");
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
        header("Location: ../pages/signin.php");
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

/**
 * Convert each array elements or single strings to UTF-8
 * @param $d
 * @return array|string
 */
function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}

function subscribe() {

    //Validate fields
    $resultValidation = validateSubscribePostFields();

    if (!$resultValidation->isSuccess()) {
        return $resultValidation;
    }

    //Get the fields
    $data_nascimento = $_POST["birthday"];
    $logradouro = $_POST["address"];
    $numero_residencia = $_POST["number"];
    $complemento= $_POST["address2"];
    $bairro = $_POST["neighborhood"];
    $id_cidade = $_POST["city"];
    $cep = $_POST["cep"];
    $telefone = $_POST["telephone"];

    //Fill model object
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

    //Save it to the database
    $resultSocio = SocioDAO::getInstance()->insertSocio($socio);

    if ($resultSocio->isSuccess()) {

        $id_socio = $resultSocio->getData();

        $id_usuario = $_SESSION["id_usuario"];
        $_SESSION["id_socio"] = $id_socio;

        //Update the 'socio' id in 'usuario' table
        $resultUsuario = UsuarioDAO::getInstance()->updatePartnerId($id_usuario, $id_socio);

        if ($resultUsuario->isSuccess()) {

            redirectToUserHomePage();

        } else {

            return getUpdatePartenerInUserErrorResponse();
        }
    } else {

        return getRegisterPartnerErrorResponse();
    }
}

function validateSubscribePostFields() {

    //PS: There is no validations for fields: 'bairro', 'numero_residencia', 'complemento'

    //Get the fields
    $nome = $_POST["name"];
    $sobrenome = $_POST["lastname"];
    $email = $_POST["email"];
    $data_nascimento = $_POST["birthday"];
    $logradouro = $_POST["address"];
    $id_estado = $_POST["state"];
    $id_cidade = $_POST["city"];
    $cep = $_POST["cep"];
    $telefone = $_POST["telephone"];

    //Name validations
    if (isEmpty($nome)) {
        return getNameCannotBeEmptyErrorResponse();
    }
    //Lastname validations
    if (isEmpty($sobrenome)) {
        return getLastnameCannotBeEmptyErrorResponse();
    }
    //Email validations
    if (isEmpty($email)) {
        return getEmailCannotBeEmptyErrorResponse();
    }

    if (!isEmailValid($email)) {
        return getInvalidEmailErrorResponse();
    }
    //Birthday validations
    if (isEmpty($data_nascimento)) {
        return getBirthdayCannotBeEmptyErrorResponse();
    }
    //Address validations
    if (isEmpty($logradouro)) {
        return getAddressCannotBeEmptyErrorResponse();
    }
    //State validations
    if (isEmpty($id_estado)) {
        return getStateCannotBeEmptyErrorResponse();
    }

    if (!existsState($id_estado)) {
        return getInvalidStateErrorResponse();
    }
    //City validations
    if (isEmpty($id_cidade)) {
        return getCityCannotBeEmptyErrorResponse();
    }

    if (!isCityBelongingToState($id_cidade, $id_estado)) {
        return getInvalidCityErrorResponse();
    }

    //CEP validations
    if (isEmpty($cep)) {
        return getPostalCodeCannotBeEmptyErrorResponse();
    }

    if (!isPostalCodeValid($cep)) {
        return getInvalidPostalCodeErrorResponse();
    }

    //Telephone Validations
    if (!isEmpty($telefone) and !isTelephoneValid($telefone)) {
        return getInvalidTelephoneErrorResponse();
    }

    return getGeneralSuccessResponse();
}

function signup() {

    //Validate fields
    $resultValidation = validateSignupPostFields();

    if (!$resultValidation->isSuccess()) {
        return $resultValidation;
    }

    $nome = $_POST['name'];
    $sobrenome = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];

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

    $result = UsuarioDAO::getInstance()->insertUser($usuario);

    if ($result->isSuccess()) {

        $usuario->setId($result->getData());
        fillSession($usuario);
        redirectToPartnerRegistration();

    } else {
        return getGeneralErrorResponse();
    }
}

function redirectToPartnerRegistration() {
    header("Location: ../pages/cadastro.php");
    exit();
}

function validateSignupPostFields() {

    $nome = $_POST['name'];
    $sobrenome = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $repeated = $_POST['confirm_pass'];

    //Name validations
    if (isEmpty($nome)) {
        return getNameCannotBeEmptyErrorResponse();
    }
    //Lastname validations
    if (isEmpty($sobrenome)) {
        return getLastnameCannotBeEmptyErrorResponse();
    }
    //Email validations
    if (isEmpty($email)) {
        return getEmailCannotBeEmptyErrorResponse();
    }

    if (!isEmailValid($email)) {
        return getInvalidEmailErrorResponse();
    }

    if (isEmailAlreadyUsed($email)) {
        return getEmailAlreadyUsedErrorResponse();
    }

    //Username validations
    if (isEmpty($username)) {
        return getEmailCannotBeEmptyErrorResponse();
    }

    if (!isUsernameValid($username)) {
        return getInvalidEmailErrorResponse();
    }

    if (isUsernameAlreadyUsed($username)) {
        return getUsernameAlreadyUsedErrorResponse();
    }

    //Password validations

    if (isEmpty($pass)) {
        return getPasswordCannotBeEmptyErrorResponse();
    }

    if (isEmpty($repeated)) {
        return getConfirmPasswordCannotBeEmptyErrorResponse();
    }

    if ($pass !== $repeated) {
        return getPassworAndConfirmPasswordMustBeEqualErrorResponse();
    }

    return getGeneralSuccessResponse();
}

function signin() {

    //TODO Use captcha

    $username = $_POST['username'];
    $pass = $_POST['pass'];

    $usuario = UsuarioDAO::getInstance()->getUserByUsernameOrEmail($username);

    if (null !== $usuario) {

        $verified = password_verify($pass, $usuario->getSenha());

        //Test $pass against the password hash stored to this user in database
        if ($verified) {

            fillSession($usuario);
            redirectToUserHomePage();

        } else {
            return getIncorrectUsernameOrPasswordErrorResponse();
        }
    }
    else {
        return getIncorrectUsernameOrPasswordErrorResponse();
    }
}


/**
 * Calculates the current Age from Birthdate informed
 * @param $birthDate The Birthdate
 * @return int The Age relative to the Birthdate
 */
function getAge($birthDate) {

    $date = new DateTime($birthDate);
    $now = new DateTime();
    $interval = $now->diff($date);

    return $interval->y;
}

/**
 * Call echo function if $_SESSION inxex $index is set. Do nothing otherwise
 * @param $index
 */
function printSessionFieldIfExists($index) {
    if (isset($_SESSION[$index])) {
        echo $_SESSION[$index];
    }
}