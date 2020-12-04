<?php
use Illuminate\Database\Capsule\Manager as DB;
require_once 'functions.php';
require_once 'header.php';

echo'
<body class="is-unselectable" onload="getproduct()">

  <div class="container is-fluid">';

    if($loggedin)
    {//consulta de members
      $sql = DB::table('members')->where('usuario', $user)->first();
      $saldo = $sql->money;
      echo'<h3 class="animate__animated animate__lightSpeedInLeft animate__fast">Saldo: <span class="money" style="display:inline-block;"><h3>' . $saldo . '</h3></span>$</h3>';
    }

echo'
  <div class="columns producto mb-4">
  ';

if(isset($_GET['id']))
{
  echo'
      <div class="textcard column is-4">
        <br>
        <div class="card">
          <div class="card-image">
            <figure class="image is-4by3">
              <img id="img" class="card-img-top" width="286px" height="190px">
            <figure>
          </div>
          <div class="card-content">
            <div class="content">
              <h5 class="card-title" id="name">Procesando...</h5>
              <form>
                <input type="hidden" id="product" value="'.$_GET['id'].'">
              </form>
              <p class="card-text" id="detalles"></p>
              <p style="color: green; name="price" id="price"></p>
              <p class="card-text" name="stock" id="stock"></p>';
              if($loggedin){
                echo'
                <a href="shop.php" type="button" class="button btn-color">Compra ahora!</a>
                ';
            }
            echo'
            </div>
          </div>
        </div>
      </div>
  ';
}
else
{
  echo'
    <h1 class="error center">No se seleccionó un producto</h1>
    <meta http-equiv="Refresh" content="2;url=shop.php">
  ';
}

echo'

    </div>
  </div>

</body>
</html>

';
?>