<?php
  use Illuminate\Database\Capsule\Manager as DB;
  require_once 'functions.php';
  require_once 'header.php';

  if (!$loggedin) die("<meta http-equiv='Refresh' content='0;url=index.php'></div</body></html>");

  if (isset($_GET['view']))
  {
    $sql = DB::table('members')->where('usuario', $user)->first();

    $saldo = $sql->money;

    $ventas = "";

    if($id == 1)
    {
      $vender = DB::table('pedidos')
      ->leftJoin('productos_pedidos', 'idpedido', '=', 'pedidos_idpedido')
      ->get();
    }

    $view = sanitizeString($_GET['view']);

    if ($view != $user) $name = "Your";
    else                $name = "$view's";

    echo"<div class='container is-fluid'>
      <h3 class='animate__animated animate__lightSpeedInLeft animate__fast'>Saldo: <span class='money' style='display:inline-block;'><h3>$saldo</h3></span>$</h3>
      <h3 class='center'>$name Profile</h3>";
    showProfile($view);
    echo "
      <a href='profile.php' type='button' class='button btn-color'>Editar perfil</a>
      ";
      if($id_miembro != 1)
      {
      echo"
      <a href='saldo.php' type='button' class='button btn-color'>añadir saldo</a>
      ";
      }
      else{
        echo'
        <div class="card mt-6 mb-4">
        <header class="card-header">
            <p class="card-header-title">
                Cancela tu(s) cita(s)
            </p>
            <a href="#" class="card-header-icon" aria-label="more options">
                <span class="icon">
                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
            </a>
        </header>
        <div class="card-content">
            <div class="content">
                <table class="table">
                    <thead>
                        <tr>
                            <th><abbr title="cita">No. Venta</abbr></th>
                            <th><abbr title="user">Usuario</abbr></th>
                            <th><abbr title="user">Cantidad</abbr></th>
                            <th><abbr title="user">Fecha</abbr></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><abbr title="cita">No. Venta</abbr></th>
                            <th><abbr title="user">Usuario</abbr></th>
                            <th><abbr title="user">Cantidad</abbr></th>
                            <th><abbr title="user">Fecha</abbr></th>
                        </tr>
                    </tfoot>
                    <tbody>';
                    foreach($vender as $a)
                    {
                      $cliente = DB::table('members')->where('idmembers', $a->members_idmembers)->first();
                      echo'
                      <tr>
                          <td>'.$a->idpedido.'</td>
                          <td>'.$cliente->usuario.'</td>
                          <td>'.$a->cantidad.'</td>
                          <td>'.$a->fecha.'</td>
                      </tr>
                      ';
                    }
                    echo'
                    </tbody>
                </table>
            </div>
        </div>
      </div>
        ';
      }
      echo'
      '.$ventas.'
    </div>';
    die("</div></body></html>");
  }
?>