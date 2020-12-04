<?php
use Illuminate\Database\Capsule\Manager as DB;

require_once 'functions.php';
require_once 'header.php';

if(!$loggedin)
{
echo'
<body class="is-unselectable css-selector">
    <div class="container is-fluid">

        <div class="columns accessform-container">
            <div class="column is-5 accessform animate__animated animate__zoomIn animate__faster">
                <h3 class="accessform-title">INICIA SESIÓN </h3>
                <h4 id="mensaje"></h4>
                <form action="login.php" method="POST">
                    <div class="field">
                        <div class="form-group col-md-12">
                            <label class="label ml-1" for="usuario">Usuario</label>
                            <input type="text" class="input" name="user" id="usuario" aria-describedby="usuario"
                                placeholder="Usuario" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="label ml-1" for="contraseña">Contraseña</label>
                            <input type="password" class="input" name="pass" id="contraseña" placeholder="Contraseña"
                                required>
                        </div>
                    </div>
                    <button type="button" class="button btn-color mt-3" onclick="login()">Iniciar sesión</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        function login()
        {
            axios.post(`api/index.php/login`, {
                user: document.forms[0].usuario.value,
                pass: document.forms[0].contraseña.value
            })
            .then(resp => {
                if(resp.data.existe)
                {
                    if(resp.data.inicio)
                    {
                        document.getElementById("mensaje").innerHTML = `Bienvenido:  ${resp.data.user} `;
                        document.getElementById("mensaje").className = "is-size-4 p-2 animate__animated animate__rubberBand check";
                        setTimeout(`location.href="shop.php?usuario=${resp.data.user}"`, 1500);
                    }
                    else
                    {
                        document.getElementById("mensaje").innerHTML = "Contraseña inválida, por favor, inténtelo de nuevo";
                        document.getElementById("mensaje").className = "is-size-4 p-2 animate__animated animate__shakeX error center";
                        document.getElementById("contraseña").value = "";
                    }
                }
                else
                {
                    document.getElementById("mensaje").innerHTML = "Usuario inválido, por favor, inténtelo de nuevo";
                    document.getElementById("mensaje").className = "is-size-4 p-2 animate__animated animate__shakeX error center";
                    document.getElementById("usuario").value = "";
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
    </script>

</body>
';

}
else {
    //! Metadata para redirijir al index
    echo'
    <meta http-equiv="Refresh" content="0;url=index.php">
    </div></body></html>
    ';
}

?>

</html>