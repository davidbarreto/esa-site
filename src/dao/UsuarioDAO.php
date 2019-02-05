<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 23/01/19
 * Time: 23:11
 */

require_once('DBConncetion.php');
require_once(__DIR__.'/../model/ModelUtils.php');
require_once(__DIR__.'/../utils/Response.php');

class UsuarioDAO
{
    private $conn;
    private static $instance;

    private function __construct() {
        $this->conn = DBConnection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new UsuarioDAO();
        }

        return self::$instance;
    }

    public function getUserByUsernameOrEmail($username) {
        $user = new Usuario();

        if (strpos($username, '@') !== false) {
            $user->setEmail($username);
        } else {
            $user->setLogin($username);
        }

        $resp = $this->getUser($user, 1);

        return (null !== $resp and !empty($resp)) ? $resp[0] : null;
    }

    public function getUser(Usuario $usuario, $limit = 0) {

        $query = <<<SQL
          SELECT u.id as id_usuario, u.login, u.senha, u.nome, u.sobrenome, u.email,
            u.data_inclusao, u.data_alteracao, u.data_exclusao,
            p.id as id_perfil, p.nome as nome_perfil, p.codigo as codigo_perfil,
            s.id as id_socio, s.logradouro, s.numero_residencia, s.telefone, 
            s.bairro, s.cep, s.data_nascimento, s.complemento, s.genero_id,
            s.complemento, s.data_inclusao, s.data_alteracao, s.data_exclusao, 
            c.id as id_cidade, c.nome as nome_cidade,
            e.id as id_estado, e.nome as nome_estado, e.uf,
            pa.id as id_pais, pa.nome as nome_pais, pa.sigla as sigla_pais
          FROM esa.usuario u
          JOIN esa.perfil p ON u.perfil_id = p.id
          LEFT JOIN esa.socio s ON u.socio_id = s.id
          LEFT JOIN esa.cidade c ON s.cidade_id = c.id
          LEFT JOIN esa.estado e ON c.estado = e.id
          LEFT JOIN esa.pais pa ON e.pais = p.id
          WHERE 1=1 
SQL;

        $params = array();

        //Parameters from Usuario
        if (null !== $usuario) {

            if (null !== $usuario->getId()) {
                $query .= "AND u.id = ? ";
                $params[] = $usuario->getId();
            }

            if (null !== $usuario->getLogin()) {
                $query .= "AND u.login = ? ";
                $params[] = $usuario->getLogin();
            }

            if (null !== $usuario->getEmail()) {
                $query .= "AND u.email = ? ";
                $params[] = $usuario->getEmail();
            }

            if (null !== $usuario->getNome()) {
                $query .= "AND UPPER(u.nome) = UPPER(?) ";
                $params[] = $usuario->getNome();
            }

            if (null !== $usuario->getSobrenome()) {
                $query .= "AND UPPER(u.sobrenome) LIKE UPPER(?) ";
                $params[] = $usuario->getSobrenome();
            }

            //Parameters from Perfil
            if (null !== $usuario->getPerfil()) {

                if (null !== $usuario->getPerfil()->getId()) {
                    $query .= "AND p.id = ? ";
                    $params[] = $usuario->getPerfil()->getId();
                }

                if (null !== $usuario->getPerfil()->getNome()) {
                    $query .= "AND UPPER(p.nome) LIKE UPPER(?) ";
                    $params[] = $usuario->getPerfil()->getNome();
                }

                if (null !== $usuario->getPerfil()->getCodigo()) {
                    $query .= "AND UPPER(u.codigo) = UPPER(?) ";
                    $params[] = $usuario->getPerfil()->getCodigo();
                }
            }

            //Parameters from Socio
            if (null !== $usuario->getSocio()) {

                if (null !== $usuario->getSocio()->getId()) {
                    $query .= "AND s.id = ? ";
                    $params[] = $usuario->getSocio()->getId();
                }

                if (null !== $usuario->getSocio()->getLogradouro()) {
                    $query .= "AND s.logradouro = ? ";
                    $params[] = $usuario->getSocio()->getLogradouro();
                }

                if (null !== $usuario->getSocio()->getNumResidencia()) {
                    $query .= "AND s.numero_residencia = ? ";
                    $params[] = $usuario->getSocio()->getNumResidencia();
                }

                if (null !== $usuario->getSocio()->getBairro()) {
                    $query .= "AND s.bairro LIKE ? ";
                    $params[] = "%".$usuario->getSocio()->getBairro()."%";
                }

                if (null !== $usuario->getSocio()->getCep()) {
                    $query .= "AND s.cep = ? ";
                    $params[] = $usuario->getSocio()->getCep();
                }

                //Parameters from Cidade
                if (null !== $usuario->getSocio()->getCidade()) {

                    if (null !== $usuario->getSocio()->getCidade()->getId()) {
                        $query .= "AND c.id = ? ";
                        $params[] = $usuario->getSocio()->getCidade()->getId();
                    }

                    if (null !== $usuario->getSocio()->getCidade()->getNome()) {
                        $query .= "AND c.nome LIKE ? ";
                        $params[] = "%".$usuario->getSocio()->getCidade()->getNome()."%";
                    }

                    //Parameters from Estado
                    if (null !== $usuario->getSocio()->getCidade()->getEstado()) {

                        if (null !== $usuario->getSocio()->getCidade()->getEstado()->getId()) {
                            $query .= "AND e.id = ? ";
                            $params[] = $usuario->getSocio()->getCidade()->getEstado()->getId();
                        }

                        if (null !== $usuario->getSocio()->getCidade()->getEstado()->getNome()) {
                            $query .= "AND e.nome LIKE ? ";
                            $params[] = "%".$usuario->getSocio()->getCidade()->getEstado()->getNome()."%";
                        }

                        if (null !== $usuario->getSocio()->getCidade()->getEstado()->getUf()) {
                            $query .= "AND e.uf = ? ";
                            $params[] = $usuario->getSocio()->getCidade()->getEstado()->getUf();
                        }

                        //Parameters from Pais
                        if (null !== $usuario->getSocio()->getCidade()->getEstado()->getPais()) {

                            if (null !== $usuario->getSocio()->getCidade()->getEstado()->getPais()->getId()) {
                                $query .= "AND pa.id = ? ";
                                $params[] = $usuario->getSocio()->getCidade()->getEstado()->getPais()->getId();
                            }

                            if (null !== $usuario->getSocio()->getCidade()->getEstado()->getPais()->getNome()) {
                                $query .= "AND pa.nome LIKE ? ";
                                $params[] = "%".$usuario->getSocio()->getCidade()->getEstado()->getPais()->getNome()."%";
                            }

                            if (null !== $usuario->getSocio()->getCidade()->getEstado()->getPais()->getSigla()) {
                                $query .= "AND pa.sigla = ? ";
                                $params[] = $usuario->getSocio()->getCidade()->getEstado()->getPais()->getSigla();
                            }
                        }
                    }
                }
            }
        }


        if ($limit > 0) {
            $query .= " LIMIT " . $limit;
        }

        $rs = $this->conn->prepare($query);

        $qtdParams = count($params);
        for ($i=0; $i < $qtdParams; ++$i) {
            $rs->bindParam($i+1, $params[$i]);
        }

        $rs = $this->conn->prepare($query);

        $qtdParams = count($params);
        for ($i=0; $i < $qtdParams; ++$i) {
            $rs->bindParam($i+1, $params[$i]);
        }

        $rs->execute();

        $usuarios = array();
        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
            $usuarios[] = ModelUtils::populateUsuario($row);
        }

        return $usuarios;
    }

    public function insertUser(Usuario $usuario) {
        $sql = <<<SQL
          INSERT INTO esa.usuario
            (login, senha, nome, sobrenome, email, perfil_id) 
          VALUES (?,?,?,?,?,?)
SQL;

        $rs = $this->conn->prepare($sql);

        $i=0;
        $rs->bindParam(++$i, $usuario->getLogin());
        $rs->bindParam(++$i, $usuario->getSenha());
        $rs->bindParam(++$i, $usuario->getNome());
        $rs->bindParam(++$i, $usuario->getSobrenome());
        $rs->bindParam(++$i, $usuario->getEmail());
        $rs->bindParam(++$i, $usuario->getPerfil()->getId());

        if (!$rs->execute()) {
            return new Response(false, Response::DB_ERROR, $rs->errorInfo()[2]);
        }

        return new Response(true, Response::SUCCESS, "Success", $this->conn->lastInsertId());
    }

    public function updatePartnerId($id_usuario, $id_socio) {

        $sql = <<<SQL
          UPDATE esa.usuario SET socio_id = ? WHERE id = ?
SQL;
        $rs = $this->conn->prepare($sql);

        $i=0;
        $rs->bindParam(++$i, $id_socio);
        $rs->bindParam(++$i, $id_usuario);

        if (!$rs->execute()) {
            return new Response(false, Response::DB_ERROR, $rs->errorInfo()[2]);
        }

        return new Response(true, Response::SUCCESS, "Success", $rs->rowCount());
    }

    public function existsUser($username) {
        $sql = <<<SQL
          SELECT 1
          FROM esa.usuario u
          WHERE u.login = ?
SQL;

        $rs = $this->conn->prepare($sql);
        $rs->bindParam(1, $username);

        $rs->execute();

        $row = $rs->fetch(PDO::FETCH_OBJ);

        return !empty($row);
    }

    public function existsEmail($email) {
        $sql = <<<SQL
          SELECT 1
          FROM esa.usuario u
          WHERE u.email = ?
SQL;

        $rs = $this->conn->prepare($sql);
        $rs->bindParam(1, $email);

        $rs->execute();

        $row = $rs->fetch(PDO::FETCH_OBJ);

        return !empty($row);
    }
}