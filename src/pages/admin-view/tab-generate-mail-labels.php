<?php

require_once(__DIR__.'/../../dao/UsuarioDAO.php');
require_once(__DIR__.'/../../model/Usuario.php');
require_once(__DIR__.'/../../model/Perfil.php');
require_once(__DIR__.'/../../utils/functions.php');

?>

<div>

    <div class="filterable">
        <div class="wrap-input100 filterable">
            <button class="btn btn-default btn-xs btn-filter">
                <span class="focus-input100" data-symbol="&#xf160;"></span>
            </button>
        </div>
        <table class="table">
            <thead>
                <tr class="filters">
                    <th><input type="text" class="form-control" placeholder="#" disabled></th>
                    <th><input type="text" class="form-control" placeholder="Login" disabled></th>
                    <th><input type="text" class="form-control" placeholder="Nome" disabled></th>
                    <th><input type="text" class="form-control" placeholder="Sobrenome" disabled></th>
                    <th><input type="text" class="form-control" placeholder="E-mail" disabled></th>
                    <th><input type="text" class="form-control" placeholder="Idade" disabled></th>
                    <th><input type="text" class="form-control" placeholder="Data de Cadastro" disabled></th>
                </tr>
            </thead>

            <tbody>

            <?php

                //Get all the users
                $filter = new Usuario();
                $perfil = new Perfil();
                $perfil->setId(Perfil::USR);
                $filter->setPerfil($perfil);

                $result = UsuarioDAO::getInstance()->getUser($filter);

                foreach ($result as $user) {

                    echo "<tr>";
                    echo "\t<td>".$user->getId()."</td>";
                    echo "\t<td>".$user->getLogin().".</td>";
                    echo "\t<td>".$user->getNome()."</td>";
                    echo "\t<td>".$user->getSobrenome()."</td>";
                    echo "\t<td>".$user->getEmail()."</td>";
                    echo "\t<td>".getAge($user->getSocio()->getDataNascimento())."</td>";
                    echo "\t<td>".$user->getDataInclusao()."</td>";
                    echo "</tr>";
                }
            ?>

            </tbody>
        </table>
    </div>
</div>
