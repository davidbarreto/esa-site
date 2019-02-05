<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 04/02/19
 * Time: 23:55
 */

session_start();

session_destroy();

header("Location: signin.php");
exit();