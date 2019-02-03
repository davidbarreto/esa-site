<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 20/01/19
 * Time: 22:34
 */

require_once('DBConncetion.php');
require_once(__DIR__.'/../model/ModelUtils.php');
require_once(__DIR__.'/../model/Estado.php');
require_once(__DIR__.'/../model/Cidade.php');

class CidadeDAO
{
    private $conn;
    private static $instance;
    private $baseQuery;

    private function __construct() {
        $this->conn = DBConnection::getInstance()->getConnection();

        //Base query to fetch states and country
        $this->baseQuery =
<<<SQL
          SELECT c.id as id_cidade, c.nome as nome_cidade,
            e.id as id_estado, e.uf, e.nome as nome_estado,
            p.id as id_pais, p.nome as nome_pais, p.sigla as sigla_pais
          FROM esa.cidade c, esa.estado e, esa.pais p WHERE e.pais = p.id AND c.estado = e.id 
SQL;

    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new CidadeDAO();
        }

        return self::$instance;
    }

    public function getCidadePorId($id_cidade) {

        $query = $this->baseQuery;
        $query .= "AND c.id = ? ";

        $rs = $this->conn->prepare($query);
        $rs->bindParam(1, $id_cidade);

        $rs->execute();

        $row = $rs->fetch(PDO::FETCH_OBJ);

        return ModelUtils::populateCidade($row);
    }

    public function getListaCidades() {

        $rs = $this->conn->prepare($this->baseQuery);
        $rs->execute();

        $cidades = array();
        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
            $cidades[] = ModelUtils::populateCidade($row);
        }

        return $cidades;
    }

    public function getListaCidadesPorEstado(Estado $filter) {

        $rs = $this->prepareEstadoQueryParameters($filter);

        $cidades = array();
        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
            $cidades[] = ModelUtils::populateCidade($row);
        }

        return $cidades;
    }

    public function getListaCidadesPorEstadoRaw(Estado $filter) {

        $rs = $this->prepareEstadoQueryParameters($filter);

        return $rs->fetchAll(PDO::FETCH_ASSOC);
    }

    private function prepareEstadoQueryParameters(Estado $filter) {

        $query = $this->baseQuery;
        $params = array();

        if (null !== $filter->getId()) {
            $query .= "AND e.id = ? ";
            $params[] = $filter->getId();
        }

        if (null !== $filter->getNome()) {
            $query .= "AND e.nome LIKE ? ";
            $params[] = "%".$filter->getNome()."%";
        }

        if (null !== $filter->getUf()) {
            $query .= "AND e.uf = ? ";
            $params[] = $filter->getUf();
        }

        $rs = $this->conn->prepare($query);

        $qtdParams = count($params);
        for ($i=0; $i < $qtdParams; ++$i) {
            $rs->bindParam($i+1, $params[$i]);
        }

        $rs->execute();

        return $rs;
    }
}