<?php

require_once('DBConncetion.php');
require_once(__DIR__.'/../model/Socio.php');
require_once(__DIR__.'/../model/ModelUtils.php');

class SocioDAO {

    private $conn;
    private static $instance;

    private function __construct() {
        $this->conn = DBConnection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new SocioDAO();
        }

        return self::$instance;
    }

    public function getSocio(Socio $filter) {
        $ret = $this->getQueryFilterSocios($filter, 1);
        return $ret[0];
    }

    public function getListaSocio(Socio $filter) {
        return $this->getQueryFilterSocios($filter);
    }

    private function getQueryFilterSocios(Socio $filter, $limit=0) {

        //SELECT
        $query = <<<SQL
          SELECT s.id as id_socio, s.nome_completo, s.logradouro, s.numero_residencia,
            s.bairro, s.cep, s.data_nascimento, s.complemento, s.genero_id, s.email,
            s.complemento, s.data_inclusao, s.data_alteracao,
            c.id as id_cidade, c.nome as nome_cidade,
            e.id as id_estado, e.nome as nome_estado, e.uf,
            p.id as id_pais, p.nome as nome_pais, p.sigla as sigla_pais  
          FROM esa.socio s, esa.cidade c, esa.estado e, esa.pais p
          WHERE s.cidade_id = c.id AND c.estado = e.id AND e.pais = p.id
            AND s.data_exclusao is NULL 
SQL;

        $params = array();

        if (null !== $filter->getId()) {
            $query .= "AND s.id = ? ";
            $params[] = $filter->getId();
        }

        if (null !== $filter->getNomeCompleto()) {
            $query .= "AND s.nome_completo LIKE ? ";
            $params[] = "%".$filter->getNomeCompleto()."%";
        }

        if (null !== $filter->getLogradouro()) {
            $query .= "AND s.logradouro = ? ";
            $params[] = $filter->getLogradouro();
        }

        if (null !== $filter->getNumResidencia()) {
            $query .= "AND s.numero_residencia = ? ";
            $params[] = $filter->getNumResidencia();
        }

        if (null !== $filter->getBairro()) {
            $query .= "AND s.bairro LIKE ? ";
            $params[] = "%".$filter->getBairro()."%";
        }

        if (null !== $filter->getCidade() && null !== $filter->getCidade()->getNome()) {
            $query .= "AND c.nome LIKE ? ";
            $params[] = "%".$filter->getCidade()->getNome()."%";
        }

        if (null !== $filter->getCidade() && null !== $filter->getCidade()->getNome()) {
            $query .= "AND c.nome LIKE ? ";
            $params[] = "%".$filter->getCidade()->getNome()."%";
        }

        if (null !== $filter->getCep()) {
            $query .= "AND s.cep = ? ";
            $params[] = $filter->getCep();
        }

        if (null !== $filter->getEmail()) {
            $query .= "AND s.email = ? ";
            $params[] = $filter->getEmail();
        }

        if ($limit > 0) {
            $query .= " LIMIT " . $limit;
        }

        $rs = $this->conn->prepare($query);

        $qtdParams = count($params);
        for ($i=0; $i < $qtdParams; ++$i) {
            $rs->bindParam($i+1, $params[$i]);
        }

        $rs->execute();

        $socios = array();
        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
            $socios[] = ModelUtils::populateSocio($row);
        }

        return $socios;
    }

    public function insertSocio(Socio $socio) {

        $sql = <<<SQL
          INSERT INTO esa.socio
            (nome_completo, logradouro, numero_residencia, bairro, cidade_id, cep, data_nascimento, complemento, email) 
          VALUES (?,?,?,?,?,?,?,?,?)
SQL;

        $rs = $this->conn->prepare($sql);

        $i=0;
        $rs->bindParam(++$i, $socio->getNomeCompleto());
        $rs->bindParam(++$i, $socio->getLogradouro());
        $rs->bindParam(++$i, $socio->getNumResidencia());
        $rs->bindParam(++$i, $socio->getBairro());
        $rs->bindParam(++$i, $socio->getCidade()->getId());
        $rs->bindParam(++$i, $socio->getCep());
        $rs->bindParam(++$i, $socio->getDataNascimento());
        $rs->bindParam(++$i, $socio->getComplementoEndereco());
        $rs->bindParam(++$i, $socio->getEmail());

        if (!$rs->execute()) {
            print_r($rs->errorInfo());
        }
    }

    public function updateSocio(Socio $socio) {

    }

    public function deleteSocio(Socio $socio) {

    }
}


