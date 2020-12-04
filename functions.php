<?php
@ob_start();
session_start();

use Illuminate\Database\Capsule\Manager as DB;
require 'vendor/autoload.php';
require 'config/database.php';

require_once 'functions.php';
$userstr = 'Welcome Guest';
if (isset($_SESSION['user'])) {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = "Sesión: $user";
    $datos = DB::table('members')->select(['idaccess', 'idmembers'])->where('usuario', $user)->first();
    $id = $datos->idaccess;
    $id_miembro = $datos->idmembers;
}
else $loggedin = FALSE;

echo <<<_INIT
<!DOCTYPE html>
<html>
    <head>
        <link rel='shortcut icon' href='images/logo.png'>

        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <!--bulma & normalize-->
        <link rel="stylesheet" href="node_modules/bulma/css/bulma.min.css">
        <link rel="stylesheet" href="node_modules/normalize.css/normalize.css">

        <!-- Animate.css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

        <!-- jquery -->
        <script src='node_modules\jquery\dist\jquery.min.js'></script>

        <script type="text/javascript" src="js/javascript.js"></script>

        <!-- web page styles -->
        <link rel='stylesheet' href='css/styles.css' type='text/css'>

        <!-- Axios -->
        <script src="node_modules/axios/dist/axios.min.js"></script>

        <script>
            function getproduct()
            {
                axios.post(`api/index.php/getproduct`, {
                    product: document.forms[0].product.value,
                })
                .then(resp => {
                    document.getElementById("img").setAttribute("src", "images/"+resp.data.img+"");
                    document.getElementById("name").innerHTML = resp.data.name;
                    document.getElementById("detalles").innerHTML = resp.data.detalles;
                    document.getElementById("price").innerHTML = "$"+resp.data.price+"";
                    document.getElementById("stock").innerHTML = "Stock: "+resp.data.stock+"";
                })
                .catch(error => {
                    console.log(error);
                });
            }
        </script>

        <title>Tienda. $userstr</title>
    </head>
_INIT;

//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

    //Tiempo en segundos para dar vida a la sesión.
    $innactive = 1800; //30 min.

    //Calculamos tiempo de vida inactivo.
    $lifeTime = time() - $_SESSION['tiempo'];

    //Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
    if ($lifeTime > $innactive) {
        //Removemos sesión.
        session_unset();
        //Destruimos sesión.
        session_destroy();
        //Redirigimos pagina.
        header("Location: login.php");

        exit();
    }
} else {
    //Activamos sesion tiempo.
    $_SESSION['tiempo'] = time();
}

function destroySession()
{
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}

function sanitizeString($var)
{
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}

function showProfile($user)
{
    $result = DB::table('profiles')->where('user','=',$user)->first();

    if ($result)
    {
        $row = $result->text;
        echo "<br style='clear:left;'>" . $row . "<br style='clear:left;'><br>";
    }
    else echo "<p><i>Escribe algo aquí</i></p><br>";
}
?>