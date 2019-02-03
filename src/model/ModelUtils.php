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
require_once('Usuario.php');
require_once('Perfil.php');

class ModelUtils
{
    static function populateSocio($row) {

        if (empty($row) or empty($row->id_socio)) {
            return null;
        }

        $socio = new Socio();

        $socio->setId($row->id_socio);
        $socio->setLogradouro($row->logradouro);
        $socio->setNumResidencia($row->numero_residencia);
        $socio->setTelefone($row->telefone);
        $socio->setBairro($row->bairro);
        $socio->setCidade(self::populateCidade($row));
        $socio->setCep($row->cep);
        $socio->setDataNascimento($row->data_nascimento);
        $socio->setComplementoEndereco($row->complemento);
        $socio->setDataInclusao($row->data_inclusao);
        $socio->setDataAlteracao($row->data_alteracao);
        $socio->setDataExclusao($row->data_exclusao);

        return $socio;
    }

    static function populateCidade($row) {

        if (empty($row) or empty($row->id_cidade)) {
            return null;
        }

        $cidade = new Cidade();

        $cidade->setId($row->id_cidade);
        $cidade->setNome($row->nome_cidade);
        $cidade->setEstado(self::populateEstado($row));

        return $cidade;
    }

    static function populateEstado($row) {

        if (empty($row) or empty($row->id_estado)) {
            return null;
        }

        $estado = new Estado();

        $estado->setId($row->id_estado);
        $estado->setUf($row->uf);
        $estado->setNome($row->nome_estado);
        $estado->setPais(self::populatePais($row));

        return $estado;
    }

    static function populatePais($row) {

        if (empty($row) or empty($row->id_pais)) {
            return null;
        }

        $pais = new Pais();

        $pais->setId($row->id_pais);
        $pais->setNome($row->nome_pais);
        $pais->setSigla($row->sigla_pais);

        return $pais;
    }

    static function populatePerfil($row) {

        if (empty($row) or empty($row->id_perfil)) {
            return null;
        }

        $perfil = new Perfil();

        $perfil->setId($row->id_perfil);
        $perfil->setNome($row->nome_perfil);
        $perfil->setCodigo($row->codigo_perfil);

        return $perfil;
    }

    static function populateUsuario($row) {

        if (empty($row) or empty($row->id_usuario)) {
            return null;
        }

        $usuario = new Usuario();

        $usuario->setId($row->id_usuario);
        $usuario->setLogin($row->login);
        $usuario->setSenha($row->senha);
        $usuario->setNome($row->nome);
        $usuario->setSobrenome($row->sobrenome);
        $usuario->setEmail($row->email);
        $usuario->setDataInclusao($row->data_inclusao);
        $usuario->setDataAlteracao($row->data_alteracao);
        $usuario->setDataExclusao($row->data_exclusao);

        $usuario->setPerfil(self::populatePerfil($row));
        $usuario->setSocio(self::populateSocio($row));

        return $usuario;
    }
}