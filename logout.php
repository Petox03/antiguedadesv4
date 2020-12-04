<?php
    require_once 'functions.php';
    require_once 'header.php';

    echo'
    <meta http-equiv="Refresh" content="0;url=login.php">
    ';

    if (isset($_SESSION['user']))
    {
        destroySession();
    }

    echo'

    </body>

    </html>
    ';

?>
