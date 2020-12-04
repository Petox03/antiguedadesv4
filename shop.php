<?php
use Illuminate\Database\Capsule\Manager as DB;
require_once "functions.php";
require_once "header.php";

if(isset($_GET['usuario']))
{
    if(!$loggedin)
    {
        $usuario = $_GET['usuario'];
        $_SESSION['user'] = $usuario;
    }
    header("Location: shop.php");
}

//consulta de productos
$productos = DB::table('productos')->get();

echo'
<body class="is-unselectable">

    <div class="container is-fluid">';

    if($loggedin)
    {
        //consulta de members
        $sql = DB::table('members')->where('usuario', $user)->first();
        $saldo = $sql->money;

        echo'<h3 class="animate__animated animate__lightSpeedInLeft animate__fast">Saldo: <span class="money" style="display:inline-block;"><h3>' . $saldo . '</h3></span>$</h3>';
    }

echo'
        <div class="columns producto">
    ';

foreach ($productos as $f)
{
    echo'
    <div class="column is-4 animate__animated animate__flipInX animate__fast">
        <br>
        <div class="card">
            <div class="card-image">
                <figure class="image is-4by3">
                    <img src="images/' . $f->img . '" class="card-img-top" width="286px" height="190px" alt="Upps, no se ha encontrado la imágen">
                </figure>
            </div>
            <div class="card-content">
                <div class="content animate__animated animate__fadeIn animate__slow">
                    <h5 class="card-title">' . $f->name . '</h5>
                    <p class="card-text">' . $f->description . '</p>
                    <p style="color: green; name="price">$' . $f->precio . '</p>
                    <a href="detalles.php?id='.$f->idproducto.'" data-transition="slide" class="button is-info" style="color: white">Ver más</a>
                    <p class="card-text" name="stock">stock:' . $f->stock . '</p>
                    ';
                    if($loggedin){
                        echo'
                        <form method="get" action="compra.php">
                            <input class="input" name="cantidad" value="0" min="1" type="number" required>
                            <input class="input" type="hidden" name="idcompra" value="'.$f->idproducto.'" type="number" >
                            <button type="submit" type="button" class="mt-3 button btn-color">Compra ahora!</button>
                        </form>
                        ';
                    }
                echo'
                </div>
            </div>
        </div>
    </div>
    ';
}

echo'

        </div>
    </div>

</body>
</html>

';

?>