<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 03/02/19
 * Time: 22:05
 */

//Generic messages
define('GENERAL_ERROR_MSG', 'Ocorreu um erro. Tente novamente mais tarde.');

//Login messages
define('LOGIN_GENERAL_ERROR_MSG', 'Error ao realizar o login. Tente novamente mais tarde.');
define('LOGIN_FAIL_ERROR', 'Usuário e/ou Senha incorretos!');
define('LOGIN_REQUIRED_ERROR', 'Login necessário!');
define('LOGIN_ALREADY_DONE', "Você já está logado. <a href='../pages/logout.php' >Logout</a>");
define('LOGIN_INCORRECT_USERNAME_OR_PASSWORD', "Usuário e/ou Senha incorretos!");

//Signup messages
define('SIGNUP_USER_ALREADY_DEFINED', 'O Nome de Usuário que você escolheu já está em uso. Tente um nome de usuário diferente.');
define('SIGNUP_EMAIL_ALREADY_DEFINED', 'O E-mail que você escolheu já está em uso. Tente um e-mail diferente.');
define('SIGNUP_PASSWORD_EMPTY', 'A Senha não pode estar em vazia');
define('SIGNUP_CONFIRM_PASSWORD_EMPTY', 'A Confirmação de Senha não pode estar vazia');
define('SIGNUP_PASSWORD_NOT_EQUAL_CONFIRM_PASSWORD', 'Senha e Confirmação de Senha estão diferentes!');
define('SIGNUP_SUCCESSFUL', 'Cadastro realizado com sucesso!');


//Partner (socio) messages
define('PARTNER_REGITER_SUCCESSFUL', 'Cadastro de sócia realizado com sucesso!');
define('PARTNER_ASSOCIATE_USER_ERROR', 'Erro ao associar o cadastro de sócia ao seu usuário. Tente novamente mais tarde');
define('PARTNER_REGISTER_ERROR', 'Erro realizar o cadastro de sócia. Tente novamente mais tarde');

define('PARTNER_NAME_EMPTY_ERROR', 'O Nome não pode estar vazio');
define('PARTNER_LASTNAME_EMPTY_ERROR', 'O Sobrenome não pode estar vazio');
define('PARTNER_EMAIL_EMPTY_ERROR', 'O E-mail não pode estar vazio');
define('PARTNER_BIRTHDAY_EMPTY_ERROR', 'A Data de Nascimento não pode estar vazia');
define('PARTNER_ADDRESS_EMPTY_ERROR', 'O Endereço não pode estar vazio');
define('PARTNER_CITY_EMPTY_ERROR', 'A Cidade não pode estar vazia');
define('PARTNER_STATE_EMPTY_ERROR', 'O Estado não pode estar vazio');
define('PARTNER_CITY_INVALID_ERROR', 'A Cidade não existe ou não pertence ao Estado');
define('PARTNER_STATE_INVALID_ERROR', 'O Estado não existe');
define('PARTNER_EMAIL_INVALID_ERROR', 'O E-mail está em um formato inválido');
define('PARTNER_TELEPHONE_INVALID_ERROR', 'O número de Whatsapp está em um formato inválido');
define('PARTNER_PÒSTALCODE_INVALID_ERROR', 'O CEP está em um formato inválido');