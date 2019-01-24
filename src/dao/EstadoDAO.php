<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 20/01/19
 * Time: 22:13
 */

require_once('DBConncetion.php');
require_once(__DIR__.'/../model/ModelUtils.php');

class EstadoDAO
{

    private $conn;
    private static $instance;
    private $baseQuery;

    private function __construct() {
        $this->conn = DBConnection::getInstance()->getConnection();

        //Base query to fetch states and country
        $this->baseQuery =
<<<SQL
            SELECT e.id as id_estado, e.uf, e.nome as nome_estado,
              p.id as id_pais, p.nome as nome_pais, p.sigla as sigla_pais
            FROM esa.estado e, esa.pais p WHERE e.pais = p.id
SQL;
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new EstadoDAO();
        }

        return self::$instance;
    }

    public function getListaEstados() {

        $rs = $this->conn->prepare($this->baseQuery);
        $rs->execute();

        $estados = array();
        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
            $estados[] = ModelUtils::populateEstado($row);
        }

        return $estados;

    }
}