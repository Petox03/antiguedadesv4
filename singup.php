<?php //Example 26-5: signup.php
use Illuminate\Database\Capsule\Manager as DB;
require_once 'functions.php';
require_once 'header.php';

echo <<<_END
    <script>
        function checkUser(user) {
            if (user.value == '') {
                $('#used').html('&nbsp;')
                return
            }
            $.post ( 'checkuser.php', { user : user.value },
                function(data) {
                    $('#used').html(data)
                }
            )
        }
    </script>
_END;
        if (isset($_SESSION['user'])) destroySession();

        if (isset($_POST['user'])) {
            $user = sanitizeString($_POST['user']);
            $pass = sanitizeString($_POST['pass']);
            $Rpass = sanitizeString($_POST['Rpass']);
            $money = 0;

        if($user == "" || $pass == "" || $Rpass == "")
            $error = 'Falta algún dato<br><br>';
        else {
            if($pass == $Rpass){
                $result = DB::table('members')->where('usuario', $user)->first();

                if ($result)
                    $error = 'Ese usuario ya existe<br><br>';
                else {
                    DB::table('members')->insertGetId(
                        ['usuario' => $user, 'pass' => $pass, 'idaccess' => '2', 'money' => 0]
                    );
                    $id_usuario = DB::table('members')->max('idmembers');
                    die('<meta http-equiv="Refresh" content="3;url=login.php">
                    <div class="check animate__animated animate__bounceInDown"><h1>Cuenta creada</h1>Por favor, inicie sesión.</div></body></html>');
                }
            }
            else{
                $error = "Las contraseñas no son iguales, inténtelo de nuevo.";
            }
        }
    }

echo<<<_singup
<body class='is-unselectable'>
    <div class="container-fluid">

        <div class="columns accessform-container mt-4 mb-2">
            <div class="column is-5 accessform animate__animated animate__zoomIn animate__faster">
                <h3 class="accessform-title">REGÍSTRATE!</h3>
                <h4 id="mensaje"></h4>
                <form action="singup.php" method="POST">
                    <div class="field">
                        <div class="control is-12">
                            <label class="label ml-1" for="usuario">Usuario</label>
                            <input type="text" class="input" name="user" id="usuario" aria-describedby="usuario"
                                placeholder="Usuario" onBlur='checkUser(this)' required>
                            <div id='used'>&nbsp;</div>
                        </div>
                        <div class="control is-12">
                            <label class="label ml-1" for="contraseña">Contraseña</label>
                            <input type="password" class="input" name="pass" id="contraseña" placeholder="Contraseña"
                            required>
                        </div>
                        <div class="control is-12">
                            <label class="label ml-1" for="contraseña">Repetir contraseña</label>
                            <input type="password" class="input" name="Rpass" id="Rcontraseña" placeholder="Repetir contraseña"
                            required>
                        </div>
                    </div>
                    <button type="button" class="button btn-color" onclick="singup()">Registrarse</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        function singup()
        {
            axios.post(`api/index.php/singup`, {
                user: document.forms[0].usuario.value,
                pass: document.forms[0].contraseña.value,
                Rpass: document.forms[0].Rcontraseña.value,
            })
            .then(resp => {
                if(resp.data.datos)
                {
                    if(resp.data.passes)
                    {
                        if(resp.data.userExist)
                        {
                            document.getElementById("mensaje").innerHTML = "Ese usuario ya está usado, por favor, utilice otro";
                            document.getElementById("mensaje").className = "p-2 animate__animated animate__shakeX error center is-size-4";
                            document.getElementById("usuario").value = "";
                        }
                        else
                        {
                            document.getElementById("mensaje").innerHTML = "Registro completado con éxito, por favor inicie sesión";
                            document.getElementById("mensaje").className = "animate__animated animate__rubberBand check is-size-3";

                            setTimeout(`location.href="login.php"`, 2000);
                        }
                    }
                    else
                    {
                        document.getElementById("mensaje").innerHTML = "Las contrasñas no son iguales, por favor, inténtelo de nuevo";
                        document.getElementById("mensaje").className = "p-2 animate__animated animate__shakeX error center is-size-4";
                        document.getElementById("Rcontraseña").value = "";
                    }
                }
                else
                {
                    document.getElementById("mensaje").innerHTML = "Falta algún dato";
                    document.getElementById("mensaje").className = "p-2 is-size-4 animate__animated animate__shakeX error center";
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
    </script>

</body>
_singup;
?>
