<?php
/**
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 02/02/19
 * Time: 21:40
 */

    header("Content-Type: text/html; charset=ISO-8859-1");

    require_once(__DIR__ . '/../dao/UsuarioDAO.php');
    require_once(__DIR__ . '/../model/Usuario.php');
    require_once(__DIR__ . '/../model/Perfil.php');

    define('MAX', '14');

    function generateLetterLabelsPDF($usuarios) {

        $total = count($usuarios);

        $pageId = 1;
        $val = 0;

        $curl_connection = setupConnection();
        $params = setupParams();

        //Fill the 'Correios Endereçador' form
        for ($i = 0; $i < $total; ++$i) {

            $usuario = $usuarios[$i];
            $val = $val + 1;

            $params["tipo_cep_" . $val] = "2";
            $params["tipo_" . $val] = "des";
            $params["cep_" . $val] = $usuario->getSocio()->getCep();
            $params["tratamento_" . $val] = "";
            $params["nome_" . $val] = utf8_decode($usuario->getNome() . ' ' . $usuario->getSobrenome());
            $params["empresa_" . $val] = "";
            $params["endereco_" . $val] = utf8_decode($usuario->getSocio()->getLogradouro());
            $params["numero_" . $val] = $usuario->getSocio()->getNumResidencia();
            $params["complemento_" . $val] = utf8_decode($usuario->getSocio()->getComplementoEndereco());
            $params["bairro_" . $val] = utf8_decode($usuario->getSocio()->getBairro());
            $params["cidade_" . $val] = utf8_decode($usuario->getSocio()->getCidade()->getNome());
            $params["uf_" . $val] = $usuario->getSocio()->getCidade()->getEstado()->getUf();
            $params["selUf_" . $val] = $usuario->getSocio()->getCidade()->getEstado()->getUf();
            $params["telefone_" . $val] = "";

            if (($i + 1) % MAX == 0) {
                createPdfPage($curl_connection, $params, $pageId);
                $curl_connection = setupConnection();
                $params = setupParams();

                $pageId++;
                $val = 0;
            }
        }

        //Fill the last page with empty records if the last page contains
        //less than MAX records
        $mod = $total % MAX;

        if ($mod > 0) {

            for ($i = $mod + 1; $i <= MAX; $i++) {
                insertEmptyRecord($params, $i);
            }

            createPdfPage($curl_connection, $params, $pageId);
        }

        echo "Generated $pageId pages...\n";
    }

    function insertEmptyRecord(& $params, $val) {

        $params["tipo_cep_".$val] = "2";
        $params["tipo_".$val] = "des";
        $params["cep_".$val] = "";
        $params["tratamento_".$val] = "";
        $params["nome_".$val] = "";
        $params["empresa_".$val] = "";
        $params["endereco_".$val] = "";
        $params["numero_".$val] = "";
        $params["complemento_".$val] = "";
        $params["bairro_".$val] = "";
        $params["cidade_".$val] = "";
        $params["uf_".$val] = "";
        $params["selUf_".$val] = "";
        $params["telefone_".$val] = "";
    }

    function createPdfPage($curl_connection, $params, $pageId)
    {
        curl_setopt($curl_connection,CURLOPT_POSTFIELDS, http_build_query($params));

        $result = curl_exec($curl_connection);
        $information = curl_getinfo($curl_connection);
        $dir = __DIR__.'/../../esa-files/etiquetas/'.date('Ymd');

        if (!is_dir($dir)) {
            //Directory does NOT exists. Make it
            mkdir($dir, 0777, true);
        }

        $path = $dir.'/etiquetas_page'.$pageId.'.pdf';

        file_put_contents($path, $result);
        curl_close($curl_connection);
    }

    function setupConnection() {

        $curl_connection = curl_init("http://www2.correios.com.br/enderecador/cartas/act/gerarEtiqueta.cfm");
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl_connection, CURLOPT_POST,true);
        curl_setopt($curl_connection, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl_connection, CURLOPT_PRIVATE, true);
        curl_setopt($curl_connection, CURLOPT_VERBOSE, true);
        curl_setopt($curl_connection, CURLOPT_ENCODING ,"ISO-8859-1");
        curl_setopt($curl_connection, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

        return $curl_connection;
    }

    function setupParams() {
        $params = array(
            "opcao"=>"etiqueta",
            "to"=>MAX,
            "tamanhoFonte"=>"P",
        );

        return $params;
    }


