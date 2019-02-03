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

    //Result Constants
    const SUCCESS = 0;
    const DB_ERROR = 1;
    const GENERAL_ERROR = 255;

    public function __construct($sucess, $statusCode = null, $statusMessage = null, $data = null)
    {
        $this->sucess = $sucess;
        $this->statusCode = $statusCode;
        $this->statusMessage = $statusMessage;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function isSucess()
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
}