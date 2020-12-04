<?php
    use Illuminate\Database\Capsule\Manager as DB;
    require_once 'functions.php';

    if (isset($_POST['user']))
    {
        $user   = sanitizeString($_POST['user']);
        $result = DB::table('members')->where('usuario', $user)->exists();

        if ($result)
            echo "<span class='taken'>&nbsp;&#x2718;" .
                "El usuario '$user' ya existe </span>";
        else
            echo "<span class='avaliable'> &nbsp;&#x2714;" .
                "El usuario '$user' está disponible </span>";
    }
?>
