<?php
/**
 * Admin page. Will be possible:
 *
 * - Filter and Ordering users (Name/Lastname, Age, City/State, Number of letters sent)
 * - View full user profile
 * - Edit user profiles
 * - Generate the mail labels
 * - Mark letters as "Sent"
 * - CRUD challenges
 * - Mask challenges as "Done"
 * - CRUD levels
 * - Associate levels and Users
 * - Send e-mail to users
 * -
 *
 * Created by PhpStorm.
 * User: dbarreto
 * Date: 03/02/19
 * Time: 19:04
 */

require_once(__DIR__ . '/../utils/functions.php');
require_once(__DIR__ . '/../model/Perfil.php');

session_start();
checkUserAuthorization(Perfil::ADM);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- This page is copyright Elated Communications Ltd. (www.elated.com) -->
        <title>ESA - Perfil Administrador</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->
        <link rel="icon" type="image/png" href="../static/images/icons/favicon.ico"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../static/vendor/bootstrap/css/bootstrap.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../static/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../static/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../static/fonts/iconic/css/material-design-iconic-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../static/vendor/animate/animate.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../static/vendor/css-hamburgers/hamburgers.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../static/vendor/animsition/css/animsition.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../static/vendor/select2/select2.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../static/vendor/daterangepicker/daterangepicker.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../static/css/util.css">
        <link rel="stylesheet" type="text/css" href="../static/css/main.css">
        <!--===============================================================================================-->
        <script src="../static/vendor/jquery/jquery-3.2.1.min.js"></script>
        <!--===============================================================================================-->
        <script src="../static/vendor/jquery-validation/jquery.validate.min.js"></script>
        <script src="../static/vendor/jquery-validation/additional-methods.min.js"></script>
        <!--===============================================================================================-->
        <script src="../static/vendor/animsition/js/animsition.min.js"></script>
        <!--===============================================================================================-->
        <script src="../static/vendor/bootstrap/js/popper.js"></script>
        <script src="../static/vendor/bootstrap/js/bootstrap.min.js"></script>
        <!--===============================================================================================-->
        <script src="../static/vendor/select2/select2.min.js"></script>
        <!--===============================================================================================-->
        <script src="../static/vendor/daterangepicker/moment.min.js"></script>
        <script src="../static/vendor/daterangepicker/daterangepicker.js"></script>
        <!--===============================================================================================-->
        <script src="../static/vendor/countdowntime/countdowntime.js"></script>
        <!--===============================================================================================-->
        <script src="../static/js/main.js"></script>
        <!--===============================================================================================-->

        <style type="text/css">
            body {
                font-size: 80%;
                font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif;
            }

            ul#tabs {
                list-style-type: none;
                margin: 30px 0 0 0;
                padding: 0 0 0.3em 0;
            }

            ul#tabs li {
                display: inline;
            }

            ul#tabs li a {
                color: #42454a;
                background-color: #dedbde;
                border: 1px solid #c9c3ba;
                border-bottom: none;
                padding: 0.3em;
                text-decoration: none;
            }

            ul#tabs li a:hover {
                background-color: #f1f0ee;
            }

            ul#tabs li a.selected {
                color: #000;
                background-color: #f1f0ee;
                font-weight: bold;
                padding: 0.7em 0.3em 0.38em 0.3em;
            }

            div.tabContent {
                border: 1px solid #c9c3ba;
                padding: 0.5em;
                background-color: #f1f0ee;
            }

            div.tabContent.hide {
                display: none;
            }
        </style>

        <script type="text/javascript">
            //<![CDATA[

            var tabLinks = new Array();
            var contentDivs = new Array();

            function init() {

                // Grab the tab links and content divs from the page
                var tabListItems = document.getElementById('tabs').childNodes;
                for (var i = 0; i < tabListItems.length; i++) {
                    if (tabListItems[i].nodeName == "LI") {
                        var tabLink = getFirstChildWithTagName(tabListItems[i], 'A');
                        var id = getHash(tabLink.getAttribute('href'));
                        tabLinks[id] = tabLink;
                        contentDivs[id] = document.getElementById(id);
                    }
                }

                // Assign onclick events to the tab links, and
                // highlight the first tab
                var i = 0;

                for (var id in tabLinks) {
                    tabLinks[id].onclick = showTab;
                    tabLinks[id].onfocus = function () {
                        this.blur()
                    };
                    if (i == 0) tabLinks[id].className = 'selected';
                    i++;
                }

                // Hide all content divs except the first
                var i = 0;

                for (var id in contentDivs) {
                    if (i != 0) contentDivs[id].className = 'tabContent hide';
                    i++;
                }
            }

            function showTab() {
                var selectedId = getHash(this.getAttribute('href'));

                // Highlight the selected tab, and dim all others.
                // Also show the selected content div, and hide all others.
                for (var id in contentDivs) {
                    if (id == selectedId) {
                        tabLinks[id].className = 'selected';
                        contentDivs[id].className = 'tabContent';
                    } else {
                        tabLinks[id].className = '';
                        contentDivs[id].className = 'tabContent hide';
                    }
                }

                // Stop the browser following the link
                return false;
            }

            function getFirstChildWithTagName(element, tagName) {
                for (var i = 0; i < element.childNodes.length; i++) {
                    if (element.childNodes[i].nodeName == tagName) return element.childNodes[i];
                }
            }

            function getHash(url) {
                var hashPos = url.lastIndexOf('#');
                return url.substring(hashPos + 1);
            }

            //]]>
        </script>
    </head>
    <body onload="init()">
        <h1>ESA - Perfil Administrador</h1>

        <ul id="tabs">
            <li><a href="#home">Home</a></li>
            <li><a href="#consult-users">Consultar Sócios</a></li>
            <li><a href="#generate-mail-labels">Gerar Etiquetas</a></li>
        </ul>

        <div class="tabContent" id="home">
            <?php
                include 'admin-view/tab-admin-home.php';
            ?>
        </div>

        <div class="tabContent" id="consult-users">
            <h2>Advantages of tabs</h2>
            <div>
                <p>JavaScript tabs are great if your Web page contains a large amount of content.</p>
                <p>They're also good for things like multi-step Web forms.</p>
            </div>
        </div>

        <div class="tabContent" id="generate-mail-labels">
            <?php
                include 'admin-view/tab-generate-mail-labels.php';
            ?>
        </div>

    </body>
</html>
