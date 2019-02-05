<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 24/01/19
 * Time: 22:26
 */

class Response
{
    private $sucess;
    private $statusCode;
    private $statusMessage;
    private $data;
    private $businessMessage;

    //Result Constants
    const SUCCESS = 0;

    const DB_ERROR = 1;
    const INCORRECT_USERNAME_OR_PASSWORD = 2;
    const REGISTER_USER_ERROR = 3;
    const REGISTER_PARTNER_ERROR = 4;
    const UPDATE_PARTNER_IN_USER_ERROR = 5;
    const UNLOGGED_ERROR = 6;
    const ALREADY_LOGGED_IN_ERROR = 7;
    const NAME_CANNOT_BE_EMPTY = 8;
    const LASTNAME_CANNOT_BE_EMPTY = 9;
    const EMAIL_CANNOT_BE_EMPTY = 10;
    const ADDRESS_CANNOT_BE_EMPTY = 11;
    const STATE_CANNOT_BE_EMPTY = 12;
    const CITY_CANNOT_BE_EMPTY = 13;
    const BIRTHDAY_CANNOT_BE_EMPTY = 14;
    const INVALID_CITY = 15;
    const INVALID_STATE = 16;
    const INVALID_POSTAL_CODE = 17;
    const INVALID_EMAIL = 18;
    const INVALID_TELEPHONE = 19;
    const EMAIL_ALREADY_USED = 20;
    const USERNAME_ALREADY_USED = 21;
    const PASSWORD_CANNOT_BE_EMPTY = 22;
    const CONFIRM_PASSWORD_CANNOT_BE_EMPTY = 23;
    const PASSWORD_CONFIRM_PASSWORD_NOT_EQUAL = 24;

    const GENERAL_ERROR = 255;

    public function __construct($sucess, $statusCode = null, $statusMessage = null, $data = null, $businessMessage = null)
    {
        $this->sucess = $sucess;
        $this->statusCode = $statusCode;
        $this->statusMessage = $statusMessage;
        $this->data = $data;
        $this->businessMessage = $businessMessage;
    }

    /**
     * @return mixed
     */
    public function isSuccess()
    {
        return $this->sucess;
    }

    /**
     * @param mixed $sucess
     */
    public function setSucess($sucess)
    {
        $this->sucess = $sucess;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return mixed
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * @param mixed $statusMessage
     */
    public function setStatusMessage($statusMessage)
    {
        $this->statusMessage = $statusMessage;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return null
     */
    public function getBusinessMessage()
    {
        return $this->businessMessage;
    }

    /**
     * @param null $businessMessage
     */
    public function setBusinessMessage($businessMessage)
    {
        $this->businessMessage = $businessMessage;
    }
}