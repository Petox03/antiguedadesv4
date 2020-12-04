<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as DB;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

// Instantiate app
$app = AppFactory::create();
$app->setBasePath("/antiguedadesv4/api/index.php");

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

// Add route callbacks
$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write('Hello World');
    return $response;
});

$app->post('/login', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $users = DB::table('members')->where('usuario', $data->user)->first();

    $msg = new stdClass();

    if($users)
    {
        $msg->existe = true;
        if($users->pass == $data->pass)
        {
            $msg->inicio = true;
            $msg->iduser = $users->idmembers;
            $msg->user = $users->usuario;
            $msg->idaccess = $users->idaccess;
        }
        else {
            $msg->inicio = false;
        }
    }
    else
    {
        $msg->existe = false;
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/singup', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $user = $data->user;
    $pass = $data->pass;
    $Rpass = $data->Rpass;

    $msg = new stdClass();

    //Validamos que las variables no estén vacías
    if($user == "" || $pass == "" || $Rpass == "")
    {
        $msg->datos = false;
    }
    else
    {
        $msg->datos = true;

        //Se validan que las contraseñas sean iguales
        if ($pass != $Rpass)
        {
            $msg->passes = false;
        }
        else
        {
            $msg->passes = true;

            //! Consulta si hay un user igual al que se intenta registrar
            $users = DB::table('members')->where('usuario', $user)->first();

            //Se comprueba si existe un user con las condiciones puestas
            if($users)
            {
                $msg->userExist = true;
            }
            else
            {
                $msg->userExist = false;

                //? Inserción de los datos del nuevo usuario a la base de datos
                $usuario = DB::table('members')->insertGetId(
                    ['usuario' => $user, 'pass' => $pass, 'money' => 0, 'idaccess' => 2]
                );

                if($usuario)
                {
                    $msg->singup = true;
                }
                else
                {
                    $msg->singup = false;
                }
            }
        }
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/getproduct', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $product = DB::table('productos')->where('idproducto', $data->product)->first();

    $msg = new stdClass();

    if($product)
    {
        $msg->product = true;
        $msg->img = $product->img;
        $msg->name = $product->name;
        $msg->detalles = $product->detalles;
        $msg->price = $product->precio;
        $msg->stock = $product->stock;
    }
    else
    {
        $msg->product = false;
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/buy', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $miembro = DB::table('members')->where('usuario', $data->user)->first();

    $saldo = $miembro->money;

    $producto = DB::table('productos')->where('idproducto', $data->idc)->first();

    $stock = $producto->stock;

    $msg = new stdClass();

    if($stock >= $data->canti){
        $msg->stock = true;
        $precio = $producto->precio * $data->canti;
        if($saldo >= $precio){
            $saldo -= $precio;
            $stock = $producto->stock;
            $newstock = $stock - $data->canti;
            $venta = DB::table('productos')
                ->where('idproducto', $data->idc)
                ->update(['stock' => $newstock]);
            if($venta)
            {
                $msg->compra = true;
                $hoy = date("Y/m/d");
                DB::table('pedidos')->insertGetId(
                    ['members_idmembers' => $data->id_user, 'fecha'=> $hoy]
                );
                $id_pedido = DB::table('pedidos')->max('idpedido');
                DB::table('productos_pedidos')->insert(
                    ['pedidos_idpedido'=>$id_pedido, 'productos_idproductos'=>$data->idc, 'cantidad'=>$data->canti]
                );
                DB::table('members')
                ->where('usuario', $data->user)
                ->update(['money' => $saldo]);
                $msg->saldo = $saldo;
            }

        }
        else{
            $msg->compra = false;
        }
    }
    else{
        $msg->stock = false;
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/perfil', function (Request $request, Response $response, array $args) {

    function sanitizeString($var)
    {
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }

    $data = json_decode($request->getBody()->getContents(), false);

    $result = DB::table('profiles')->where('user', $data->user)->first();

    $text = sanitizeString($data->text);
    $text = preg_replace('/\s\s+/', ' ',$text);
    if ($result)
    {
        $modi = DB::table('profiles')
        ->where('user', $data->user)
        ->update(['text' => $data->text]);
    }
    else{
        $modi = DB::table('profiles')->insert(['members_idmembers'=>$data->id_user, 'user'=>$data->user, 'text'=>$data->text]);
    }

    $msg = new stdClass();

    if($modi)
    {
        $msg->modi = true;
    }
    else {
        $msg->modi = false;
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

// Run application
$app->run();