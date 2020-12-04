<?php
use Illuminate\Database\Capsule\Manager as DB;
require_once 'functions.php';
require_once 'header.php';
if (!$loggedin) die("<meta http-equiv='Refresh' content='0;url=index.php'></div></body></html>");
echo "<div class='container is-fluid'>
<h3 class='center'>Your Profile</h3>";
$result = DB::table('profiles')->where('user', $user)->first();

if ($result) {
    $text = stripslashes($result->text);
}
else $text = "";

$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));
showProfile($user);
echo <<<_END
                <form method='post' action='profile.php' enctype='multipart/form-data'>
                    <div class="form-group col-md-8">
                        <h3>Enter or edit your details and/or upload image</h3>
                        <textarea name='text' id="text" class="textarea">$text</textarea><br>
                    </div>
                    <input class="is-hidden" id="id_user" value="$id_miembro">
                    <input class="is-hidden" id="user" value="$user">
                    <button type='button' class='button btn-color mt-2' onclick="perfil()">Guardar</button>
                </form>
            </div><br>
        </div>
    </body>
    <script>
        function perfil()
        {
            axios.post(`api/index.php/perfil`, {
                user: document.forms[0].user.value,
                id_user: document.forms[0].id_user.value,
                text: document.forms[0].text.value
            })
            .then(resp => {
                if(resp.data.modi)
                {
                    alert("Perfil modificado con éxito")
                    location.href="profile.php";
                }
                else
                {
                    alert("Algo ha ido mal")
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
    </script>
</html>
_END;
?>