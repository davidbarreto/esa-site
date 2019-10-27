<?php

require_once(__DIR__.'/../../dao/UsuarioDAO.php');
require_once(__DIR__.'/../../model/Usuario.php');

?>

<div>

    <?php

        //Filter users of "USR" type (not ADM)
        $filter = new Usuario();
        $perfil = new Perfil();
        $perfil->setId(Perfil::USR);
        $filter->setPerfil($perfil);

        $dao = UsuarioDAO::getInstance();

        //Get total users
        $qtdUsers = $dao->countUsers($filter);

        //Get last users subscribed

        $result = $dao->getUser($filter,0, 3, "u.data_inclusao", "DESC");

        echo "<p>Estamos com $qtdUsers usuários cadastrados:</p>";

        echo "<p>Últimos usuários cadastrados</p>";

        foreach ($result as $user) {
            echo "<p>".$user->getNome()." ".$user->getSobrenome()."</p>";
        }

    ?>
</div>
