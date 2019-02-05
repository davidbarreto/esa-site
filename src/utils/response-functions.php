<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 04/02/19
 * Time: 22:44
 */

// Functions to fill Response object

//Fail Responses

function getUnloggedErrorResponse() {
    return new Response(false, Response::UNLOGGED_ERROR,
        null, null, LOGIN_REQUIRED_ERROR);
}

function getAlreadyLoggedErrorResponse() {
    return new Response(false, Response::ALREADY_LOGGED_IN_ERROR,
        null, null, LOGIN_ALREADY_DONE);
}

function getUpdatePartenerInUserErrorResponse() {

    return new Response(
        false, Response::UPDATE_PARTNER_IN_USER_ERROR, null,
        null, PARTNER_ASSOCIATE_USER_ERROR);
}

function getRegisterPartnerErrorResponse() {

    return new Response(
        false, Response::REGISTER_PARTNER_ERROR, null,
        null, PARTNER_REGISTER_ERROR);
}

function getNameCannotBeEmptyErrorResponse() {
    return new Response(
        false, Response::NAME_CANNOT_BE_EMPTY, null,
        null, PARTNER_NAME_EMPTY_ERROR);
}

function getLastnameCannotBeEmptyErrorResponse() {
    return new Response(
        false, Response::LASTNAME_CANNOT_BE_EMPTY, null,
        null, PARTNER_LASTNAME_EMPTY_ERROR);
}

function getEmailCannotBeEmptyErrorResponse() {
    return new Response(
        false, Response::EMAIL_CANNOT_BE_EMPTY, null,
        null, PARTNER_EMAIL_EMPTY_ERROR);
}

function getAddressCannotBeEmptyErrorResponse() {
    return new Response(
        false, Response::ADDRESS_CANNOT_BE_EMPTY, null,
        null, PARTNER_ADDRESS_EMPTY_ERROR);
}

function getStateCannotBeEmptyErrorResponse() {
    return new Response(
        false, Response::STATE_CANNOT_BE_EMPTY, null,
        null, PARTNER_STATE_EMPTY_ERROR);
}

function getCityCannotBeEmptyErrorResponse() {
    return new Response(
        false, Response::CITY_CANNOT_BE_EMPTY, null,
        null, PARTNER_CITY_EMPTY_ERROR);
}

function getBirthdayCannotBeEmptyErrorResponse() {
    return new Response(
        false, Response::BIRTHDAY_CANNOT_BE_EMPTY, null,
        null, PARTNER_BIRTHDAY_EMPTY_ERROR);
}

function getPostalCodeCannotBeEmptyErrorResponse() {
    return new Response(
        false, Response::POSTALCODE_CANNOT_BE_EMPTY, null,
        null, PARTNER_POSTALCODE_EMPTY_ERROR);
}

function getInvalidTelephoneErrorResponse() {
    return new Response(
        false, Response::INVALID_TELEPHONE, null,
        null, PARTNER_TELEPHONE_INVALID_ERROR);
}

function getInvalidEmailErrorResponse() {
    return new Response(
        false, Response::INVALID_EMAIL, null,
        null, PARTNER_EMAIL_INVALID_ERROR);
}

function getInvalidStateErrorResponse() {
    return new Response(
        false, Response::INVALID_STATE, null,
        null, PARTNER_STATE_INVALID_ERROR);
}

function getInvalidCityErrorResponse() {
    return new Response(
        false, Response::INVALID_CITY, null,
        null, PARTNER_CITY_INVALID_ERROR);
}

function getInvalidPostalCodeErrorResponse() {
    return new Response(
        false, Response::INVALID_CITY, null,
        null, PARTNER_CITY_INVALID_ERROR);
}

function getEmailAlreadyUsedErrorResponse() {
    return new Response(
        false, Response::EMAIL_ALREADY_USED, null,
        null, SIGNUP_EMAIL_ALREADY_DEFINED);
}

function getUsernameAlreadyUsedErrorResponse() {
    return new Response(
        false, Response::USERNAME_ALREADY_USED, null,
        null, SIGNUP_USER_ALREADY_DEFINED);
}

function getPasswordCannotBeEmptyErrorResponse() {
    return new Response(
        false, Response::PASSWORD_CANNOT_BE_EMPTY, null,
        null, SIGNUP_PASSWORD_EMPTY);
}

function getConfirmPasswordCannotBeEmptyErrorResponse() {
    return new Response(
        false, Response::CONFIRM_PASSWORD_CANNOT_BE_EMPTY, null,
        null, SIGNUP_CONFIRM_PASSWORD_EMPTY);
}

function getPassworAndConfirmPasswordMustBeEqualErrorResponse() {
    return new Response(
        false, Response::PASSWORD_CONFIRM_PASSWORD_NOT_EQUAL, null,
        null, SIGNUP_PASSWORD_NOT_EQUAL_CONFIRM_PASSWORD);
}

function getIncorrectUsernameOrPasswordErrorResponse() {
    return new Response(
        false, Response::INCORRECT_USERNAME_OR_PASSWORD, null,
        null, LOGIN_INCORRECT_USERNAME_OR_PASSWORD);
}

function getGeneralErrorResponse() {
    return new Response(
        false, Response::GENERAL_ERROR, Response::GENERAL_ERROR,
        null, GENERAL_ERROR_MSG);
}

//Success responses

function getRegisterPartnerSuccessResponse() {
    return new Response(
        true, Response::SUCCESS, null,
        null, PARTNER_REGITER_SUCCESSFUL);
}

function getGeneralSuccessResponse() {
    return new Response(true);
}