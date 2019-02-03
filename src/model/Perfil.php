<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 02/02/19
 * Time: 23:42
 */

class Perfil
{
    const UNLOGGED = 0;
    const ADM = 1;
    const USR = 2;

    private $id;
    private $nome;
    private $codigo;
    private $dataInclusao;
    private $dataAlteracao;
    private $dataExclusao;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getDataInclusao()
    {
        return $this->dataInclusao;
    }

    /**
     * @param mixed $dataInclusao
     */
    public function setDataInclusao($dataInclusao)
    {
        $this->dataInclusao = $dataInclusao;
    }

    /**
     * @return mixed
     */
    public function getDataAlteracao()
    {
        return $this->dataAlteracao;
    }

    /**
     * @param mixed $dataAlteracao
     */
    public function setDataAlteracao($dataAlteracao)
    {
        $this->dataAlteracao = $dataAlteracao;
    }

    /**
     * @return mixed
     */
    public function getDataExclusao()
    {
        return $this->dataExclusao;
    }

    /**
     * @param mixed $dataExclusao
     */
    public function setDataExclusao($dataExclusao)
    {
        $this->dataExclusao = $dataExclusao;
    }
}