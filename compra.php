<?php
use Illuminate\Database\Capsule\Manager as DB;
require_once 'functions.php';
require_once 'header.php';
if (!$loggedin) die("<meta http-equiv='Refresh' content='0;url=index.php'></div></body></html>");

echo'
<body class="is-unselectable" onload="buy()">
';

if(isset($_GET['idcompra']))
{
    if($_GET['cantidad'] != 0)
    {
        $idc = $_GET['idcompra'];
        $cantidad = $_GET['cantidad'];

        echo'
        <form>
            <input class="is-hidden" id="idc" value="'.$idc.'">
            <input class="is-hidden" id="cantidad" value="'.$cantidad.'">
            <input class="is-hidden" id="user" value="'.$user.'">
            <input class="is-hidden" id="id_user" value="'.$id_miembro.'">
        </form>
        ';

        $sql = DB::table('members')->where('usuario', $user)->first();
        $saldo = $sql->money;

        echo'
        <div class="container is-fluid">
            <h3 id="saldo">Saldo: <span class="money" style="display:inline-block;"><h3 id="Nsaldo">' . $saldo . '</h3></span>$</h3>
            <h1 id="mensaje" class="center">Procesando...</h1>
        </div>

        <script>
            function buy()
            {
                axios.post(`api/index.php/buy`, {
                    idc: document.forms[0].idc.value,
                    user: document.forms[0].user.value,
                    canti: document.forms[0].cantidad.value,
                    id_user: document.forms[0].id_user.value
                })
                .then(resp => {
                    if(resp.data.stock)
                    {
                        if(resp.data.compra)
                        {
                            document.getElementById("mensaje").innerHTML = "GRACIAS POR SU COMPRA!";
                            document.getElementById("mensaje").className = "check";
                            document.getElementById("Nsaldo").innerHTML = resp.data.saldo;
                            setTimeout(`location.href="shop.php"`, 3000);
                        }
                        else
                        {
                            document.getElementById("saldo").style.display = "none";
                            document.getElementById("mensaje").innerHTML = "NO TIENES SALDO SUFICIENTE";
                            document.getElementById("mensaje").className = "error center";
                            setTimeout(`location.href="shop.php"`, 3000);
                        }
                    }
                    else
                    {
                        document.getElementById("saldo").style.display = "none";
                        document.getElementById("mensaje").innerHTML = "NO HAY PRODUCTOS SUFICIENTES";
                        document.getElementById("mensaje").className = "error center";
                        setTimeout(`location.href="shop.php"`, 3000);
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            }
        </script>
        ';
    }
    else
    {
        die("<meta http-equiv='Refresh' content='3;url=shop.php'><h1 class='error center'>CANTIDAD NO VÁLIDA, POR FAVOR, SELECCIONA UNA CANTIDAD MAYOR A 0</h1>");
    }
}
else{
    die("<meta http-equiv='Refresh' content='3;url=shop.php'><h1 class='error center'>NO SELECCIONASTE UN PRODUCTO</h1>");
}

echo'
</body>
</html>
';

?>