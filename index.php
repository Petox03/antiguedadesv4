<?php
    require_once 'functions.php';
    require_once 'header.php';

    echo '<div class="center">Bienvenido a "tienda de atiguedades"';

    if($loggedin) echo " $user, Usted tiene una sesión activa";
    else          echo ' Por favor. Regístrese o inicie sesión';

    echo <<<_END
        </div><br>
        </div>
        <div data-role="footer">
            <h4 class="info">Aplicación web hecha por:<i><a href='https://petox03.github.io'
            target='_blank'>Alberto Sosa<a/a></i><h4>
        </div>
    </body>
</html>
_END;

?>
