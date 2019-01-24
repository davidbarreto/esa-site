<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 20/01/19
 * Time: 22:25
 */

require_once('Socio.php');
require_once('Cidade.php');
require_once('Estado.php');
require_once('Pais.php');

class ModelUtils
{

    static function populateSocio($row) {

        $socio = new Socio();

        $socio->setId($row->id_socio);
        $socio->setNomeCompleto($row->nome_completo);
        $socio->setLogradouro($row->logradouro);
        $socio->setNumResidencia($row->numero_residencia);
        $socio->setCidade(self::populateCidade($row));
        $socio->setCep($row->cep);
        $socio->setDataNascimento($row->data_nascimento);
        $socio->setComplementoEndereco($row->complemento);

        return $socio;
    }

    static function populateCidade($row) {

        $cidade = new Cidade();

        $cidade->setId($row->id_cidade);
        $cidade->setNome($row->nome_cidade);
        $cidade->setEstado(self::populateEstado($row));

        return $cidade;
    }

    static function populateEstado($row) {
        $estado = new Estado();

        $estado->setId($row->id_estado);
        $estado->setUf($row->uf);
        $estado->setNome($row->nome_estado);
        $estado->setPais(self::populatePais($row));

        return $estado;
    }

    static function populatePais($row) {

        $pais = new Pais();

        $pais->setId($row->id_pais);
        $pais->setNome($row->nome_pais);
        $pais->setSigla($row->sigla_pais);

        return $pais;
    }
}