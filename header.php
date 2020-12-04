<?php
if ($loggedin) {
echo <<<_LOGGEDIN
    <nav class="navbar bg-dark" role="navigation" aria-label="main navigation">
        <img src='images/logo.png' class="mt-2 ml-2 mb-2" id='icon'>
        <div class="navbar-brand">
            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start a">
                <a class="navbar-item a" href='shop.php'>
                    Tienda
                </a>
                <a class="navbar-item a" href='members.php?view=$user'>
                    Perfil
                </a>
                <a class="navbar-item a" href='logout.php'>
                    Salir
                </a>
            </ul>
        </div>
    </nav>
_LOGGEDIN;
    }
else {
echo <<<_GUEST
    <nav class="navbar bg-dark" role="navigation" aria-label="main navigation">
        <img src='images/logo.png' class="mt-2 ml-2 mb-2" id='icon'>
        <div class="navbar-brand">
            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start a">
                <a class="navbar-item a" href='shop.php'>
                    Inicio
                </a>
                <a class="navbar-item a" href='login.php'>
                    Iniciar sesión
                </a>
                <a class="navbar-item a" href='singup.php'>
                    Regístrate
                </a>
            </ul>
        </div>
    </nav>
    _GUEST;
}
echo <<<_MAIN
        <div data-role='page' class='mb-3'>
            <div data-role='header'>
                <div class= 'username'>$userstr</div>
            </div>
        </div>
    _MAIN;
if(!$loggedin)
{
    echo"
    <p class='info'>(Debes tener una cuenta para usar esta app)</p>
    ";
}

?>