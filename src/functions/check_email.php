<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 26/01/19
 * Time: 15:23
 */

    require_once(__DIR__.'/../utils/validation-functions.php');

    $email = isset($_GET['email']) ? $_GET['email'] : '';

    if (!empty($email)) {

        $result = isEmailAlreadyUsed($email);

        //If the result is not empty (email already exists in database), return false
        //beacuse this is email cannot be used. Return true otherwise, meaning that
        //the email can be used
        if ($result) {
            echo "false";
        } else {
            echo "true";
        }
    }