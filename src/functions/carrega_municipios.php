<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 20/01/19
 * Time: 23:11
 */

    require_once(__DIR__.'/../dao/CidadeDAO.php');
    require_once(__DIR__.'/../model/Estado.php');

    $id_estado = isset($_GET['id_uf']) ? $_GET['id_uf'] : '';

    if (!empty($id_estado)) {

        $estado = new Estado();
        $estado->setId($id_estado);

        $result = CidadeDAO::getInstance()->getListaCidadesPorEstadoRaw($estado);

        echo json_encode(utf8ize($result));
    }

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