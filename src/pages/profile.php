<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 03/02/19
 * Time: 19:04
 */

require_once(__DIR__.'/../utils/functions.php');
require_once (__DIR__.'/../model/Perfil.php');

session_start();
checkUserAuthorization(Perfil::USR);

echo "NORMAL USER";